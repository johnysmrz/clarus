<?php

namespace cms;

class Loader extends \clarus\loader\Loader {

    protected $cache = array();
    protected $phpFiles = array();
    protected $classes = array();

    protected function load($class) {
        if (isset($this->classes[$class])) {
            include_once($this->classes[$class]);
        }
    }

    protected function onCreate() {
        $cacheFile = \PATH_CACHE . '/cmsLoader.cache';
        $this->createCache();
        /* if(\file_exists($cacheFile)) {
          $this->classes = \unserialize(\file_get_contents($cacheFile));
          } else {
          $this->createCache();
          \file_put_contents($cacheFile, \serialize($this->classes));
          } */
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
                    if ($namespace === NULL) {
                        $this->classes[$className] = $filePath;
                    } else {
                        $this->classes['\\'.$namespace . '\\' . $className] = $filePath;
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

}