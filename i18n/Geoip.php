<?php

namespace clarus\i18n;

/**
 * Description of Geoip
 * @author Jan Smrz
 * @package clarus
 * @subpackage i18n
 */
class Geoip {

    /**
     * @var string IP adress given in constructor or retrieved from $_SERVER['REMOTE_ADDR']
     */
    protected $ip = NULL;
    /**
     * @var string ISO country code
     */
    protected $countryCode = NULL;
    /**
     * @var string Country name readed from geoip DB
     */
    protected $countryName = NULL;
    /**
     * @var bool Indicates if current IP is from internal (private) ip range, class is able to indicate A B or C Class
     */
    protected $isInternal = FALSE;
    /**
     * @var bool Indicates if current IP is a special loopback adress from 127.x.x.x range
     */
    protected $isLoopback = FALSE;

    /**
     * Constructor
     * @param string $ip IP adress for wich you want retrieve information
     */
    public function __construct($ip = NULL) {
        if ($ip === NULL) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        list($byte1, $byte2, $byte3, $byte4) = explode('.', $ip);

        $this->ip = $ip;

        if (($byte1 == '192' && $byte2 == '168') || $byte1 == '10' || ($byte1 == '172' && $byte2 == '16')) {
            $this->isInternal = TRUE;
            $this->countryName = 'Internal network';
        } else if ($byte1 == '127') {
            $this->isLoopback = TRUE;
            $this->countryName = 'Loopback';
        } else {
            $this->countryCode = geoip_country_code_by_name($ip);
            $this->countryCode3 = geoip_country_code3_by_name($ip);
            $this->countryName = geoip_country_name_by_name($ip);
        }
    }

    public function setCountryCode($countryCode) {
        $this->countryCode = $countryCode;
    }

    public function setCountryName($countryName) {
        $this->countryName = $countryName;
    }

}