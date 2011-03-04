<?php

/**
 * Description of Templater
 *
 * @author johny
 */
class templater_Templater {

    public function __construct() {
        
    }

    public function getCompiledTemplate($originalFileName) {
        if (!file_exists($originalFileName)) throw new scl_FileNotFoundException($originalFileName);
        $originalFileName = realpath($originalFileName);

        $compiledFileName = $this->getCompiledFileName($originalFileName);

        if (file_exists($compiledFileName)) {
            $originalFileMTime = filemtime($originalFileName);
            $compiledFileMTime = filemtime($compiledFileName);
            if ($originalFileMTime !== $compiledFileMTime) {
                $this->compileTemplate($originalFileName);
            }
        } else {
            $this->compileTemplate($originalFileName);
        }

        return $compiledFileName;
    }

    protected function compileTemplate($originalFileName) {
        if (!file_exists($originalFileName)) throw new scl_FileNotFoundException($originalFileName);
        $templateContent = file_get_contents($originalFileName);
        $compiledFileName = $this->getCompiledFileName($originalFileName);
        $templateContent = $this->parser($templateContent);
        //trigger_error('Compiling: '.$originalFileName, E_USER_NOTICE);
        touch($originalFileName);
        file_put_contents($compiledFileName, $templateContent);
    }

    protected function getCompiledFileName($originalFileName) {
        return PATH_TPL_C . '/' . md5($originalFileName);
    }

    protected function parser($content) {
        return preg_replace_callback('~\{([a-zA-Z0-9_ $]+)\}~', array($this, 'resolveToken'), $content);
    }

    protected function resolveToken($token) {
        $token = $token[1];
        $newToken = $token;
        if (preg_match('~^\$([a-zA-Z0-9_-]+)$~', $token, $matches)) {
            $newToken = '<?php echo $this->getTplVar(\'' . $matches[1] . '\') ?>';
        } else if ($token == 'content') {
            $newToken = '<?php include_once($this->templater->getCompiledTemplate($this->contentTpl)) ?>';
        }

        return $newToken;
    }

}