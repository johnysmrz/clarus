<?php

namespace cms;

class Loader extends \clarus\loader\Loader implements \Serializable {

    protected $cache = array();
    protected $phpFiles = array();
    protected $classes = array();

    protected function load($class) {
        if (isset($this->classes[$class])) {
            include_once($this->classes[$class]);
        }
    }

    protected function onCreate() {
        if(\file_exists(\PATH_CACHE.'/cmsLoader.cache')) {
            
        }
        echo '<pre>' . print_r(\PATH_CACHE, true) . '</pre>';
        $this->createCache();
    }

    protected function createCache() {
        $this->fetchPHPFiles(\PATH_APP);
        foreach ($this->phpFiles as $filePath) {
            $namespace = NULL;
            $tokens = \token_get_all(\file_get_contents($filePath));
            foreach ($tokens as $key => $token) {
                if ($token[0] == \T_NAMESPACE) {
                    $namespace = $tokens[$key + 2][1];
                }
                if ($token[0] == \T_CLASS) {
                    $className = $tokens[$key + 2][1];
                    if ($namespace === \NULL) {
                        $this->classes[$className] = $filePath;
                    } else {
                        $this->classes[$namespace . '\\' . $className] = $filePath;
                    }
                }
            }
        }
    }

    protected function fetchPHPFiles($dir) {
        foreach (new \DirectoryIterator($dir) as $value) {
            if ($value->isDir() && !$value->isDot() && \substr($value->getFilename(), 0, 1) !== '.') {
                $this->fetchPHPFiles($value->getPathname());
            } else if ($value->isFile()) {
                if (\preg_match('~.*\.php$~', $value->getFilename())) {
                    $this->phpFiles[] = $value->getPathname();
                }
            }
        }
        return;
    }

    public function serialize() {

    }

    public function unserialize($serialized) {
        
    }

}