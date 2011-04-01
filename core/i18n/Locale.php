<?php

namespace clarus\i18n;

/**
 * Trida pro manipulaci s lokalizacnimi udaji
 * @author Jan Smrz
 * @package clarus
 * @subpackage i18n
 */
class Locale extends \clarus\scl\SingletonObject {

    private $locale = NULL;
    private static $instance = NULL;

    /**
     * Vraci instanci
     * @return i18n_Locale
     */
    public static function getInstance() {
        if (self::$instance instanceof self) {
            return self::$instance;
        } elseif (isset($_SESSION['_locale']) && (($locale = unserialize($_SESSION['_locale'])) instanceof self)) {
            return self::$instance = $locale;
        } else {
            return self::$instance = new self();
        }
    }

    protected function __construct() {
        $this->setLocale();
    }

    /**
     * Vraci aktualni locale kod
     * @return string
     */
    public function getLocale() {
        return $this->locale;
    }

    /**
     * Nastavi locale a vrati jej
     * Nejdriv se pokusi nastavit locale podle parametru,
     * pote podle nastaveni browseru, pote defaultni hodnotu z initu
     * a nakonec zkusi cs_CZ a nakonec C ktere je vsude
     * @param string $requestLocale
     * @return string
     */
    public function setLocale($requestLocale = NULL) {
        $locales = $this->detectFromBrowser();
        if ($requestLocale !== NULL) {
            array_unshift($locales, $requestLocale);
        }
        if (defined('DEFAULT_LOCALE')) {
            array_push($locales, DEFAULT_LOCALE);
        }
        array_push($locales, 'cs_CZ.utf8', 'C');
        foreach ($locales as $locale) {
            if (setlocale(LC_ALL, $locale) !== FALSE) {
                return $this->locale = $locale;
            }
        }
    }

    /**
     * Detekuje jazyk z accept language posilane browserem
     * Vrati pole detekovanych jazyku, pokud se nepovede tak false
     * @return array/bool
     */
    protected function detectFromBrowser() {
        $detected = array();
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            foreach (explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) as $order => $loc) {
                $loc = explode(';', $loc, 2);
                $locale = $loc[0];
                switch ($locale) {
                    case 'en':
                    case 'en-US':
                        $detected[] = 'en_US.utf8';
                        break;
                    case 'cs':
                    case 'cs-CZ':
                        $detected[] = 'cs_CZ.utf8';
                        break;
                }
            }
            if (sizeof($detected) > 0) {
                return $detected;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Pri deserializaci znovunastavi locale
     */
    public function __wakeup() {
        setlocale(LC_ALL, $this->locale);
    }

    /**
     * Ulozi sama sebe do session aby nebylo potreba stale dokolecka delat detekci locale
     */
    public function __destruct() {
        $_SESSION['_locale'] = serialize($this);
    }

}