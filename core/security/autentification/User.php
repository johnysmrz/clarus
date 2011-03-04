<?php

/**
 * Factory vracejici objekt prihlaseneho uzivatele, v pripade ze jej nelze najit
 * vyhazuje exception
 * @throws security_autentification_Exception
 * @throws UnexpectedValueException
 * @version 1.0
 * @author Jan "Johny" Smrz
 */
class security_autentification_User extends object_Static {

    const IAnonymousUser = 'security_autentification_IAnonymousUser';

    

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

        if (isset($_SESSION['_user']) && ($user = unserialize($_SESSION['_user'])) instanceof $interface) {
            return self::$userObject = $user;
        }

        throw new security_autentification_Exception('Not autorized', 1);
    }

    /**
     * Autentifikuje uzivatele pomoci predaneho autentifikatoru
     * @param IAutentificator $autentificator
     * @return IUser
     */
    public static function autentificate(security_autentification_IAutentificator $autentificator) {
        if ($autentificator->isAutentificate()) {
            if (($user = $autentificator->getUserObject()) instanceof security_autentification_IUser) {
                self::$userObject = $user;
                $_SESSION['_user'] = serialize($user);
                return $user;
            } else {
                throw new UnexpectedValueException('security_autentification_IAutentificator->getUserObject() should return security_autentification_IUser object', 1);
            }
        } else {
            throw new security_autentification_Exception('Not autorized', 1);
        }
    }

    /**
     * Provede odhlaseni uzivatele, zrusi session i vnitrni vazby
     */
    public static function logout() {
        unset(self::$userObject);
        unset($_SESSION['_user']);
    }

}