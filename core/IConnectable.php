<?php

/**
 * Rozhrani pro vsechny konektory
 */
interface IConnectable {

    /**
     * Metoda provede pripojeni ke zdroji
     */
    public function connect();

    /**
     * Overi zda je pripojeni vytvoreno, vraci TRUE pokud ano, jinak FALSE
     * @return bool
     */
    public function checkConnection();

}