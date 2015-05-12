<?php

namespace clarus\security\autentification;

/**
 * Interface for all future autentificators
 * @author Jan Smrz
 * @package clarus
 * @subpackage security
 */
interface IAutentificator {

    /**
     * Check if user is autetificated return TRUE if is, FALSE overwise
     * @return bool
     */
    public function isAutentificate();

    /**
     * Get current user object
     * @return \clarus\security\autentification\IUser
     */
    public function getUser();

}