<?php

abstract class clo_Mapper {

    private static $mappers = array();
    private $attributes = array();
    private $reverseAttributes = array();
    private $entityClassName = null;

    /**
     *
     * @param Clo_Mapper $mapperClass
     * @return Clo_Mapper
     */
    public static function getMapper($mapperClass) {
        if (isset(self::$mappers[$mapperClass]) && $mapperClass instanceof clo_Mapper)
            return self::$mappers[$mapperClass];

        if (class_exists($mapperClass))
            self::$mappers[$mapperClass] = new $mapperClass();
        else
            throw new clo_Exception('Mapper [' . $mapperClass . '] does not exists!', 1);

        return self::$mappers[$mapperClass];
    }

    /**
     *
     * @param Traversable $data
     * @return entity
     */
    final public function createEntity(Traversable $data) {
        $entity = $this->entityClassName;
        return new $entity($this->filterMapAttributes($data), $this);
    }

    final protected function setAttribute($name, $tableColumn = null) {
        if ($tableColumn === null)
            $tableColumn = $name;
        $this->attributes[$name] = array('col' => $tableColumn, 'type' => 'attr');
        $this->reverseAttributes[$tableColumn] = $name;
    }

    final protected function setPrimary($name, $tableColumn) {
        $this->attributes[$name] = array('col' => $tableColumn, 'type' => 'pk');
        $this->reverseAttributes[$tableColumn] = $name;
    }

    final protected function setEntity($entityClassName) {
        if (class_exists($entityClassName))
            $this->entityClassName = $entityClassName;
        else
            throw new clo_Exception('Mapper [' . $mapperClass . '] does not exists!', 1);
    }

    final protected function setConnectionToMany($name, $dao, $method, $params) {
        $this->attributes[$name] = array('dao' => $dao, 'method' => $method, 'params' => $params, 'type' => 'connMany');
    }

    final protected function setConnectionToOne($name, $dao, $method, $params) {
        $this->attributes[$name] = array('dao' => $dao, 'method' => $method, 'params' => $params, 'type' => 'connOne');
    }

    final public function evalAttribute($attributeName, array $entityRawValues) {
        switch ($this->attributes[$attributeName]['type']) {
            case 'attr':
            case 'pk':
                return $entityRawValues[$attributeName];
                break;
            case 'connMany':
            case 'connOne':
                $attrs = explode(' ', $this->attributes[$attributeName]['params']);
                $params = array();
                foreach ($attrs as $attrStr) {
                    list($key, $value) = explode('=', $attrStr, 2);
                    $params[$key] = $entityRawValues[$value];
                }
                if ($this->attributes[$attributeName]['type'] == 'connMany') {
                    return clo_Clo::get($this->attributes[$attributeName]['dao'], $this->attributes[$attributeName]['method'], $params);
                } else {
                    $one = clo_Clo::get($this->attributes[$attributeName]['dao'], $this->attributes[$attributeName]['method'], $params);
                    return $one[0];
                }
                break;
            default:
                throw new Clo_Exception('Cannot eval [' . $attributeName . '] attribute because does not exists or have unknown type', 1);
        }
    }

    private function __construct() {
        $this->setUp();
        if (empty($this->entityClassName))
            throw new clo_Exception('Mapper Entity Class must be specified!', 1);
    }

    private function filterMapAttributes(Traversable $data) {
        $output = array();
        foreach ($data as $key => $value) {
            if (isset($this->reverseAttributes[$key])) {
                $output[$this->reverseAttributes[$key]] = $value;
            }
        }
        return $output;
    }

    abstract protected function setUp();
}

?>
