<?php

/**
 * Interface pro komponenty ktere lze predat do view a pote zobrazit
 */
interface IDisplayable {
    public function display($return = FALSE);
}