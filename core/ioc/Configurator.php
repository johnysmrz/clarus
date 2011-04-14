<?php

namespace clarus\ioc;

/**
 * Reads configuration from given xml and create internal BeanConfiguration objects
 * @author Jan Smrz
 * @package clarus
 * @subpackage ioc
 */
class Configurator {

    protected $beans = array();

    /**
     * @param string $xml beans valid xml string
     */
    public function __construct($xml) {

        $wd = \getcwd();
        \set_error_handler(array($this, 'internalErrorHandler'));
        \chdir(\PATH_CORE . '/ioc');
        $xmlDom = new \DOMDocument();
        $xmlDom->loadXML($xml);
        $xmlDom->validate();
        \chdir($wd);
        \restore_error_handler();

        $beans = new \SimpleXMLElement($xml);

        foreach ($beans as $bean) {
            $beanAttributes = $this->attributesToArr($bean->attributes());
            $beanConfigurator = new BeanConfiguration($beanAttributes['id'], $beanAttributes['class']);
            $this->readConstrucorArgs($bean, $beanConfigurator);
            $this->readPeels($bean);
            $this->beans[] = $beanConfigurator;
        }
    }

    /**
     * Read peels elements from bean section
     * If some peel is found, create configurator
     * @param \SimpleXMLElement $bean
     */
    protected function readPeels(\SimpleXMLElement $bean) {
        $beanAttributes = $this->attributesToArr($bean->attributes());
        foreach ($bean->children() as $key => $value) {
            if ((string) $key == 'peel') {
                $peelAttributes = $this->attributesToArr($value->attributes());
                $peelClass = isset($peelAttributes['class']) ? $peelAttributes['class'] : $beanAttributes['class'];
                $peelConfigurator = new BeanConfiguration($beanAttributes['id'], $peelClass);
                $this->readConstrucorArgs($value, $peelConfigurator);
                foreach (\explode(';', $peelAttributes['for']) as $forClass) {
                    $peelConfigurator->addFor($forClass);
                }
                $this->beans[] = $peelConfigurator;
            }
        }
    }

    /**
     * Read constructor-arg elements from bean section
     * @param \SimpleXMLElement $bean
     * @param BeanConfiguration $beanConfigurator
     */
    protected function readConstrucorArgs(\SimpleXMLElement $bean, BeanConfiguration $beanConfigurator) {
        foreach ($bean->children() as $key => $value) {
            if ((string) $key == 'constructor-arg') {
                $arg = $this->attributesToArr($value->attributes());
                if (!isset($arg['index']))
                    $arg['index'] = \NULL;
                if (!isset($arg['type']))
                    $arg['type'] = NULL;

                switch ($arg['type']) {
                    case 'str':
                    default:
                        $beanConfigurator->addArg($arg['index'], (string) $arg['value']);
                        break;
                    case 'int':
                        $beanConfigurator->addArg($arg['index'], (int) $arg['value']);
                        break;
                    case 'float':
                        $beanConfigurator->addArg($arg['index'], (float) $arg['value']);
                        break;
                }
            }
        }
    }

    /**
     * read attributes from element and return it as array
     * @param \SimpleXMLElement $element
     * @return array
     */
    protected function attributesToArr(\SimpleXMLElement $element) {
        $attributes = array();
        foreach ($element as $key => $value) {
            $attributes[(string) $key] = (string) $value;
        }
        return $attributes;
    }

    /**
     * Search configurator for BeanConfiguration by given beanName and Object
     * When fails, thwows \InvalidArgumentException
     * @throws \InvalidArgumentException
     * @param string $beanName
     * @param object $object
     * @return BeanConfiguration
     */
    public function getConfiguration($beanName, $object) {
        foreach ($this->beans as $key => $value) {
            if ($value->getId() == $beanName) {
                if (\sizeof($value->getFor()) == 0) {
                    return $value;
                } else {
                    foreach ($this->getClassLineage($object) as $ancester) {
                        $ancester = '\\'.$ancester;
                        foreach ($value->getFor() as $for) {
                            if(($wildCharPost = \strpos($for, '*')) !== \FALSE) {
                                $forPart = \substr($for, 0, $wildCharPost);
                                if(\strpos($ancester, $forPart) === 0) {
                                    return $value;
                                }
                            } else {
                                if($for == $ancester) {
                                    return $value;
                                }
                            }
                        }
                    }
                }
            }
        }
        throw new \InvalidArgumentException('Configuration for bean [' . $beanName . '] not found', 1);
    }

    /**
     * Get all ancesters of given object
     * @param object $object
     * @return array
     */
    protected function getClassLineage($object) {
        $class_name = get_class($object);
        $parents = array_values(class_parents($class_name));
        return array_merge(array($class_name), $parents);
    }

    /**
     * @internal
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     */
    public function internalErrorHandler($errno, $errstr, $errfile, $errline) {
        throw new \clarus\xml\ValidityException($errstr, $errno);
    }

}