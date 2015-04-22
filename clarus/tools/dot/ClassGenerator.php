<?php

namespace clarus\tools\dot;

class ClassGenerator {
    const MODIFIER_ABSTRACT = 1;
    const MODIFIER_FINAL = 2;

    protected $cache = array();
    protected $phpFiles = array();
    protected $classes = array();
    protected $interfaces = array();
    protected $colorPool = array(
        '#FF0000', //red
        '#FF0000', //maroon
        '#808000', //olive
        '#00FF00', //lime
        '#008000', //green
        '#008080', //teal
        '#0000FF', //blue
        '#000080', //navy
        '#FF00FF', //fuchsia
        '#800080', //purple
        '#A52A2A', //bown
        '#5F9EA0', //cadet blue
        '#DC143C', //crimson
        '#008B8B', //dark cyan
        '#006400', //dark green
        '#8B0000', //dark red
        '#FFD700', //gold
        '#DAA520', //goldenrod
        '#F0E68C', //khaki
        '#FF4500', //orange red
        '#9ACD32'  //yellow green
    );
    protected $colorForInterfaces = array();

    public function __construct($rootFolder) {
        $this->createCache($rootFolder);
    }

    public function createDot() {
        $output = "digraph PHP {\n";
        // first create entities and labels
        foreach ($this->classes as $classInfo) {
            $output .= "\t" . $this->getClass($classInfo) . ' ' . $this->getClassOptions($classInfo) . ";\n";
        }

        foreach ($this->classes as $classInfo) {
            // create edge for extension
            if (isset($classInfo['extends'])) {
                $output .= "\t" . \stripslashes($classInfo['extends']) . " -> " . $this->getClass($classInfo) . " [minlen=1];\n";
            }
        }



        // create interfaces
        foreach ($this->interfaces as $interface) {
            $output .= "\t" . $this->getInterface($interface) . ' ' . $this->getInterfaceOptions($interface) . ";\n";
        }


        // create edges for interfaces
        foreach ($this->classes as $classInfo) {
            foreach ($classInfo['interfaces'] as $interface) {
                $class = $classInfo['class'];
                $output .= "\t" . $this->getInterface($interface) . ' -> ' . $this->getClass($classInfo) . " [style=dotted,color=\"".$this->getColorForInterface($interface)."\"];\n";
            }
        }
        $output .= "}";
        return $output;
    }

    protected function getClass($classInfo) {
        return \stripslashes($classInfo['class']);
    }

    protected function getClassOptions($classInfo) {
        $options[] = 'label="' . \str_replace('\\', '\\\\', $classInfo['class']) . '"';
        $options[] = 'shape=box';
        switch ($classInfo['modifier']) {
            case self::MODIFIER_ABSTRACT:
                $options[] = 'style=dashed';
                break;
            case self::MODIFIER_FINAL:
                $options[] = 'style=bold';
                break;
        }
        return '[' . \implode(',', $options) . ']';
    }

    protected function getInterface($interface) {
        return \stripslashes($interface);
    }

    protected function getInterfaceOptions($interface) {
        $options[] = 'label="' . \str_replace('\\', '\\\\', $interface) . '"';
        $options[] = 'color="' . $this->getColorForInterface($interface) . '"';
        return '[' . \implode(',', $options) . ']';
    }

    protected function createClassNodeEntry($class) {
        return \str_replace('\\', '', $class) . " [label=\"$class\"]";
    }

    protected function getColorForInterface($interface) {
        if (!isset($this->colorForInterfaces[$interface])) {
            $this->colorForInterfaces[$interface] = \next($this->colorPool);
        }
        return $this->colorForInterfaces[$interface];
    }

    protected function createCache($rootFolder) {
        $this->fetchPHPFiles($rootFolder);
        $i = 0;
        foreach ($this->phpFiles as $filePath) {
            $namespace = NULL;
            $tokens = \token_get_all(\file_get_contents($filePath));
            $block = NULL;
            $blockType = NULL;
            foreach ($tokens as $key => $token) {
                if (!\is_array($token)) {
                    // dump
                    switch ($blockType) {
                        case \T_NAMESPACE:
                            $namespace = $block;
                            break;
                    }
                    $blockType = NULL;
                    $block = \NULL;
                    continue;
                }

                if ($blockType == \T_NAMESPACE) {
                    if ($token[0] !== \T_WHITESPACE) {
                        $block .= $token[1];
                    }
                }

                if ($token[0] == \T_NAMESPACE) {
                    $blockType = \T_NAMESPACE;
                }

                if ($token[0] == \T_CLASS) {
                    $this->onClassFound(($namespace === NULL ? NULL : '\\' . $namespace) . '\\' . $tokens[$key + 2][1], $filePath);
                }
            }
        }
    }

    protected function onClassFound($class, $path) {

        if (!\class_exists($class)) {
            include_once($path);
        }

        $classInfo['class'] = $class;

        if (\class_exists($class)) {
            $reflector = new \ReflectionClass($class);
            $classInfo['interfaces'] = $reflector->getInterfaceNames();
            foreach ($reflector->getInterfaceNames() as $interface) {
                if (!\in_array($interface, $this->interfaces)) {
                    $this->interfaces[] = $interface;
                }
            }
            $parent = $reflector->getParentClass();
            if ($parent instanceof \ReflectionClass) {
                if (\strpos($class, '\\') === FALSE) {
                    $classInfo['extends'] = $parent->getName();
                } else {
                    $classInfo['extends'] = '\\' . $parent->getName();
                }
            }
            $classInfo['modifier'] = NULL;
            if ($reflector->isAbstract()) {
                $classInfo['modifier'] = self::MODIFIER_ABSTRACT;
            }
            if ($reflector->isFinal()) {
                $classInfo['modifier'] = self::MODIFIER_FINAL;
            }
        } else {
            \trigger_error('Class [' . $class . '] not found in [' . $path . ']', \E_USER_NOTICE);
        }

        $this->classes[] = $classInfo;
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