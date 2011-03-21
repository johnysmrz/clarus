<?php

/*
 * @package main
 * @SimpleAnnotation
 * @BoolAnnotation(true)
 * @NumberAnnotation(-3.141592)
 * @StringAnnotation('Hello World!')
 * @SimpleArrayAnnotation({1, 2, 3, "hello", TRUE, false, NULL, 1.22})
 * @MultiValuedAnnotation(key = 'value', anotherKey = false, andMore = 1234)
 */

/**
 * Trida pro cteni anotaci
 * Zvlada vsechny inline anotace vcetne doc komentu, viz priklad vyse
 * Generuje anotace vcetne typovosti
 * @author Jan Smrz
 * @package reflection
 * @throws InvalidArgumentException
 */
class reflection_AnnotationsReader extends object_Singleton {

    private static $pool = array();
    protected $annotations = array();

    protected function __construct($doc) {
        $this->annotations = $this->parseDoc($doc);
    }

    /**
     * Cte anotace k tride
     * @param string/object $class
     * @return reflection_AnnotationsReader
     */
    public static function fromClass($class) {
        if (gettype($class) == 'object') {
            $class = get_class($class);
        }
        if (isset(self::$pool['class'][$class])) {
            return self::$pool['class'][$class];
        } else {
            $reflector = new ReflectionClass($class);
            return self::$pool['class'][$class] = new reflection_AnnotationsReader($reflector->getDocComment());
        }
    }

    /**
     * Cte anotace k metode tridy
     * @param string/object $class
     * @param string $method
     * @return reflection_AnnotationsReader
     */
    public static function fromMethod($class, $method) {
        if (gettype($class) == 'object') {
            $class = get_class($class);
        }
        if (isset(self::$pool['methods'][$class][$method])) {
            return self::$pool['methods'][$class][$method];
        } else {
            $reflector = new ReflectionMethod($class, $method);
            return self::$pool['methods'][$class][$method] = new reflection_AnnotationsReader($reflector->getDocComment());
        }
    }

    public function __get($name) {
        if (isset($this->annotations[$name])) {
            return $this->annotations[$name];
        } else {
            throw new InvalidArgumentException("Annotation [$name] not found", 1);
        }
    }

    protected function parseDoc($doc) {
        $annotations = NULL;
        preg_match_all('~@(?<annotationName>[a-zA-Z0-9]+) ?((\((?<annotationValue>.+)\))|(?<nonAnnotationValue>[a-z]*))?~', $doc, $matches);

        foreach ($matches['annotationName'] as $key => $name) {
            $value = $matches['annotationValue'][$key];
            if (strlen($matches['nonAnnotationValue'][$key]) > 0) {
                $annotations[$name] = $matches['nonAnnotationValue'][$key];
            } else if ('' === $value) {
                $annotations[$name] = NULL;
            } else if ('TRUE' === strtoupper($value) || 'FALSE' === strtoupper($value)) {
                $annotations[$name] = (bool) $value;
            } else if (preg_match('~^(|-)[0-9]+(|\.[0-9]+)$~', $value)) {
                $annotations[$name] = (float) $value;
            } else if (preg_match('~^(\'|")(?<string>[\H ]+)\1$~', $value, $match)) {
                $annotations[$name] = $match['string'];
            } else if (preg_match('~^\{(.+)\}$~', str_replace(' ', '', $value), $match)) {
                foreach (explode(',', $match[1]) as $arrKey => $arrValue) {
                    if (preg_match('~^[0-9]+$~', $arrValue, $valueMatch)) {
                        $annotations[$name][] = (int) $valueMatch[0];
                    } else if (preg_match('~^[0-9]+$~', $arrValue, $valueMatch)) {
                        $annotations[$name][] = (int) $valueMatch[0];
                    } else if (preg_match('~^(\'|")(?<string>[\H ]+)\1$~', $arrValue, $valueMatch)) {
                        $annotations[$name][] = $valueMatch['string'];
                    } else if (preg_match('~^(|-)[0-9]+(|\.[0-9]+)$~', $arrValue, $valueMatch)) {
                        $annotations[$name][] = $arrValue;
                    } else if (strtolower($arrValue) == 'true') {
                        $annotations[$name][] = TRUE;
                    } else if (strtolower($arrValue) == 'false') {
                        $annotations[$name][] = FALSE;
                    } else if (strtolower($arrValue) == 'null') {
                        $annotations[$name][] = NULL;
                    }
                }
            } else if (preg_match('~^[a-zA-Z0-9 \,\=\"\\\']+$~', str_replace(' ', '', $value), $match)) {
                foreach (explode(',', $match[0]) as $arrPair) {
                    list ($arrKey, $arrValue) = explode('=', $arrPair, 2);
                    if (preg_match('~^[0-9]+$~', $arrValue, $valueMatch)) {
                        $annotations[$name][$arrKey] = (int) $valueMatch[0];
                    } else if (preg_match('~^[0-9]+$~', $arrValue, $valueMatch)) {
                        $annotations[$name][$arrKey] = (int) $valueMatch[0];
                    } else if (preg_match('~^(\'|")(?<string>[\H ]+)\1$~', $arrValue, $valueMatch)) {
                        $annotations[$name][$arrKey] = $valueMatch['string'];
                    } else if (preg_match('~^(|-)[0-9]+(|\.[0-9]+)$~', $arrValue, $valueMatch)) {
                        $annotations[$name][$arrKey] = $arrValue;
                    } else if (strtolower($arrValue) == 'true') {
                        $annotations[$name][$arrKey] = TRUE;
                    } else if (strtolower($arrValue) == 'false') {
                        $annotations[$name][$arrKey] = FALSE;
                    } else if (strtolower($arrValue) == 'null') {
                        $annotations[$name][$arrKey] = NULL;
                    }
                }
            }
        }

        return $annotations;
    }

}