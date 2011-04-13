<?php

namespace clarus\ioc;

use clarus\reflection\AnnotationsReader as AnnotationsReader;

class Container extends \clarus\scl\SingletonObject {
    const CONF_TYPE_XML = 1;
    const CONF_TYPE_INI = 2;

    /**
     * @var Container
     */
    private static $instance = NULL;
    /**
     * @var IConfigurator
     */
    private $configurator = NULL;
    /**
     * @var array
     */
    private $beans = array();

    public static function inject(IInjectable $object) {
        $i = self::getInstance();
        $objReflector = new \ReflectionClass($object);
        foreach ($objReflector->getProperties() as $property) {
            $annotations = AnnotationsReader::fromDoc($property->getDocComment());
            try {
                $instance = self::getInstance();
                $beanName = $annotations->IocInejct;
                $property->setAccessible(TRUE);
                $property->setValue($object, $instance->getBean($beanName));
                $property->setAccessible(FALSE);
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
            self::$instance = new self(PATH . '/ioc.xml');
        }
        return self::$instance;
    }

    protected function __construct($configuration, $type = self::CONF_TYPE_XML) {
        switch ($type) {
            case self::CONF_TYPE_XML:
                $this->configurator = new XMLConfigurator(\file_get_contents($configuration));
                break;
            case self::CONF_TYPE_INI:
                \trigger_error('Not implemented!', \E_USER_ERROR);
                break;
        }
    }

    protected function getBean($beanName) {
        if (!isset($this->beans[$beanName])) {
            $this->beans[$beanName] = $this->createBean($beanName);
        }
        return $this->beans[$beanName];
    }

    protected function createBean($beanName) {
        $conf = $this->configurator->getBeanByName($beanName);
        eval ('$bean = new '.$conf['class'].'("'.  \implode('","', $conf['attributes']).'");');
    }

}