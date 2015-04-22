<?php

namespace clarus\ioc;

use clarus\reflection\AnnotationsReader as AnnotationsReader;

/**
 * IOC Container itself
 * @author Jan Smrz
 * @package clarus
 * @subpackage ioc
 */
class Container extends \clarus\scl\SingletonObject {

    /**
     * @var Container
     */
    private static $instance = NULL;
    /**
     * @var Configurator
     */
    private $configurator = NULL;
    /**
     * @var array
     */
    private $beans = array();

    /**
     * Inject beans into given object
     * @param IInjectable $object
     * @return IInjectable 
     */
    public static function inject(IInjectable $object) {
        $objReflector = new \ReflectionClass($object);
        foreach ($objReflector->getProperties() as $propertyReflector) {
            $instance = self::getInstance();
            try {
                $propertyReflector->setAccessible(TRUE);
                $propertyReflector->setValue($object, $instance->getBean(AnnotationsReader::fromDoc($propertyReflector->getDocComment())->IocInject, $object));
                $propertyReflector->setAccessible(FALSE);
            } catch (\UnexpectedValueException $uev) {
                continue;
            }
        }
        return $object;
    }

    /**
     * @return Container
     */
    protected static function getInstance() {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self(PATH_CONF . '/ioc.xml');
        }
        return self::$instance;
    }

    /**
     * @param string $configuration path to configuration file
     */
    protected function __construct($configuration) {
        if (\file_exists($configuration)) {
            $this->configurator = new Configurator(\file_get_contents($configuration));
        } else {
            throw new \clarus\scl\FileNotFoundException($configuration);
        }
    }

    /**
     * Get bean object for given combination
     * @todo persistent behaviour
     * @param string $beanName
     * @param object $object
     * @return mixed
     */
    protected function getBean($beanName, $object) {
        $configuration = $this->configurator->getConfiguration($beanName, $object);
        $configurationHash = \md5(\serialize($configuration));
        switch ($configuration->getBehaviour()) {
            case Configuration::BEHAVIOUR_NEW:
                return $this->createBean($configuration);
                break;
            case Configuration::BEHAVIOUR_SHARED:
                if (!isset($this->beans[$configurationHash])) {
                    $this->beans[$configurationHash] = $this->createBean($configuration);
                }
                return $this->beans[$configurationHash];
                break;
            case Configuration::BEHAVIOUR_PERSISTENT:
                throw new \clarus\scl\NotImplementedException('Persistent behaviour not yet implemented!', 1);
                break;
        }
    }

    /**
     * Create new bean from given configuration
     * @param Configuration $configuration
     * @return mixed
     */
    protected function createBean(Configuration $configuration) {
        return function()use($configuration) {
            $reflector = new \ReflectionClass($configuration->getClass());
            return $reflector->newInstanceArgs($configuration->getArgs());
        };
    }

}