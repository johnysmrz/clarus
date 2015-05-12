<?php

namespace clarus\scl;

class ErrorHandler {

    protected $previous = NULL;

    public function __construct($previous = NULL) {
        $this->previous = $previous;
    }

    public function handlePHPError($errType, $errMsg, $errFile, $errLine, $errEnv = array()) {
        if (\class_exists('\FB') && \FB::getEnabled()) {
            $label = $errFile . '(' . $errLine . ')';
            switch ($errType) {
                case \E_ERROR:
                case \E_USER_ERROR:
                case \E_RECOVERABLE_ERROR:
                default:
                    \FB::error($errMsg, $label);
                    break;
                case \E_WARNING:
                case \E_USER_WARNING:
                case \E_USER_DEPRECATED:
                    \FB::warn($errMsg, $label);
                    break;
                case \E_NOTICE:
                case \E_USER_NOTICE:
                    \FB::info($errMsg, $label);
                    break;
            }
        } else {
            \var_dump($errType, $errMsg, $errFile, $errLine);
        }
    }

}