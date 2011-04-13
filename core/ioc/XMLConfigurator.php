<?php

namespace clarus\ioc;

class XMLConfigurator implements IConfigurator {

    protected $beans = array();

    /**
     * @param string $xmlString beans valid xml string
     */
    public function __construct($xmlString) {
        $wd = \getcwd();
        \chdir(\PATH_CORE . '/ioc');
        $xml = new \DOMDocument();
        $xml->loadXML($xmlString);
        $xml->validate();
        \chdir($wd);

        $beans = $xml->getElementsByTagName('bean');
        for ($i = 0; $i < $beans->length; $i++) {
            $bean = $beans->item($i);
            $this->beans[$bean->getAttribute('id')]['class'] = $bean->getAttribute('class');
            $args = $bean->getElementsByTagName('constructor-arg');
            for ($j = 0; $j < $args->length; $j++) {
                $arg = $args->item($j);
                if ($arg->getAttribute('index') == '') {
                    $this->beans[$bean->getAttribute('id')]['attributes'][] = $arg->getAttribute('value');
                } else {
                    $this->beans[$bean->getAttribute('id')]['attributes'][(int) $arg->getAttribute('index')] = $arg->getAttribute('value');
                }
            }
            \ksort($this->beans[$bean->getAttribute('id')]['attributes']);
        }
    }

    /**
     * @param string $beanName
     * @throws \InvalidArgumentException
     * @return array
     */
    public function getBeanByName($beanName) {
        if (isset($this->beans[$beanName])) {
            return $this->beans[$beanName];
        } else {
            throw new \InvalidArgumentException('Configuration for bean [' . $beanName . '] not found', 1);
        }
    }

}