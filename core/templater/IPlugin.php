<?php

namespace clarus\templater;

interface IPlugin {

    /**
     * Should return resolved string
     * @param string $name
     * @param string $args
     * @return string
     */
    public function resolve($type, $args);

    /**
     * returns all tokens wich can be handled
     * @return array
     */
    public function getAbilities();
}