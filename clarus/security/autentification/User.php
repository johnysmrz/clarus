<?php

namespace clarus\security\autentification;

/**
 * Factory returning object of currently logged user
 * @throws Exception
 * @throws \UnexpectedValueException
 * @author Jan Smrz
 * @package clarus
 * @subpackage security
 */
class User extends \clarus\scl\StaticObject {

    /**
     * @var IUser
     */
    protected static $userObject = NULL;

    /**
     * Vraci objekt prihlaseneho uzivatele, v pripade chyby vyhazuje exception
     * @return IUser
     */
    public static function get($interface) {
        if (self::$userObject instanceof $interface) {
            return self::$userObject;
        }

        if (isset($_SESSION['_user'])) {
            $user = unserialize($_SESSION['_user']);
            if ($user instanceof IUser) {
                return self::$userObject = $user;
            }
        }

        throw new Exception('Not autorized', 1);
    }

    /**
     * Autentifikuje uzivatele pomoci predaneho autentifikatoru
     * @param IAutentificator $autentificator
     * @return IUser
     */
    public static function autentificate(IAutentificator $autentificator) {
        if ($autentificator->isAutentificate()) {
            if (($user = $autentificator->getUser()) instanceof IUser) {
                self::$userObject = $user;
                $_SESSION['_user'] = serialize($user);
                return $user;
            } else {
                throw new \UnexpectedValueException(__NAMESPACE__ . 'IAutentificator->getUserObject() should return ' . __NAMESPACE__ . 'IUser object', 1);
            }
        } else {
            throw new Exception('Not autorized', 1);
        }
    }

    /**
     * Provede odhlaseni uzivatele, zrusi session i vnitrni vazby
     */
    public static function logout() {
        self::$userObject = NULL;
        unset($_SESSION['_user']);
    }

}