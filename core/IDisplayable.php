<?php

namespace clarus;

/**
 * Interface pro komponenty ktere lze predat do view a pote zobrazit
 */
interface IDisplayable {

    /**
     * Zobrazi komponentu
     */
    public function display($template = NULL);

    /**
     * Definuje pristup k promenym komponenty
     */
    public function getTplVar($name);
}