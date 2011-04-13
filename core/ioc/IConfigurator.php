<?php

namespace clarus\ioc;

interface IConfigurator {
    public function getBeanByName($beanName);
}