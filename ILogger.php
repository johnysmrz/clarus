<?php

namespace clarus;

/**
 * Interface defines logger role
 */
interface ILogger {
    public function log($message, $data = null);
}