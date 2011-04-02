<?php

/**
 * @author Jan Smrz
 * @package Clo
 * Abstraktni trida resici zakladni funkcnost DAO - Data Access Object
 * Poskytuje budoucim tridam metody pro pridavani entit do vystupni kolekce a
 * upravuje chovani tak aby bylo korektni
 */
abstract class clo_Dao implements clo_IDao {

    /**
     * @var string Definuje ktera obsluzna metoda se ma pouzit pri nacitani
     */
    private $method;
    /**
     * @var array Pole parametru predavanych do budouci obsluzne metody
     */
    private $params;
    /**
     * @var array Kolekce vystupnich dat
     */
    private $collection = array();
    /**
     * If parameter is set to TRUE, system uses default caching
     * If is FALSE, system skips using of cache
     * @var mixed Contains reference to caching object
     */
    private $cache = array();
    /**
     * @var array Optional flags
     */
    private $flags = array();

    /**
     * Spolecny konstruktor vsech budoucich DAO objektu
     * @param string $method nazev obsluzne metody
     * @param array $params parametry pro obsluznou funkci
     */
    final public function __construct($method, array $params, $cache = TRUE, array $flags = array()) {
        if (method_exists($this, $method))
            $this->method = $method;
        else
            throw new clo_DaoException('Method [' . $method . '] does not exists', 1);

        $this->params = new clo_ParamCollection($params);
        $this->cache = $cache;
        $this->flags = $flags;
    }

    /**
     * Vrati parametry pro obsluznou funkci
     * @return array
     */
    final protected function getParams() {
        return $this->params;
        trigger_error('Use $this->param->paramName instead', E_USER_DEPRECATED);
    }

    final protected function getParam($key) {
        return $this->params->$key;
        trigger_error('Use $this->param->paramName instead', E_USER_DEPRECATED);
    }

    /**
     * Getter
     * @param string $key
     * @return mixed
     */
    final public function __get($key) {
        switch ($key) {
            case 'params':
                return $this->params;
                break;
            case 'globals':
                return clo_Clo::getGloabalVariables();
                break;
            case 'connection':
                return clo_Clo::getConnection();
                break;
            default:
        }
    }

    /**
     * Prida entitu do vystupni kolekce
     * @param Clo_Entity $entity
     */
    final protected function addCollectionItem(clo_Entity $entity) {
        $this->collection[] = $entity;
    }

    /**
     * Vrati vystupni kolekci nemelo by byt volano samostatne
     * public je pouze proto ze PHP neumi friently metody a cela knihovna neni namespaced
     * @return array
     */
    final public function getCollection() {
        $cacheHash = 'DAO' . md5(get_class() . $this->method . serialize($this->params));

        $cacheCollection = apc_fetch($cacheHash, $success);
        if ($success) {
            $this->collection = $cacheCollection;
        } else {
            $method = $this->method;
            $this->$method($this->params);
            apc_add($cacheHash, $this->collection, 1);
        }

        //apc_delete($cacheHash);

        return $this->collection;
    }

}

?>
