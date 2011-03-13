<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Debugger
 *
 * @author johny
 */
class Debugger {

    public static function _init() {
        
    }


    public static function showException(Exception $e) {
        try {
            $tpl = templater_Templater::get(PATH_TPL.'/system/exception.php');
            include_once($tpl);
        } catch (scl_FileNotFoundException $fnfe) {
            echo '!!!!!!!!Not found template for exception, switching to std echo!!!!!!!!!!';
            echo '<pre>' . print_r($e, true) . '</pre>';
        }
    }

}
?>
