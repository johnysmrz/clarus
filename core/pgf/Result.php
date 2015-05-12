<?php

namespace clarus\pgf;

/**
 * @license http://www.gnu.org/copyleft/gpl.html
 * @author Jan Smrž <jan-smrz@jan-smrz.cz>
 * @package clarus
 * @subpackage pgf
 */
class Result {

    /**
     * @var \PDOStatement
     */
    protected $statement = NULL;
    protected $meta = NULL;

    public function __construct(\PDOStatement $statement) {
        $this->statement = $statement;
    }

    public function fetch() {
        $data = $this->statement->fetch(\PDO::FETCH_NUM);
        if ($this->meta === NULL) {
            $cols = $this->statement->columnCount();
            for ($i = 0; $i < $cols; $i++) {
                $this->meta[$i] = $this->statement->getColumnMeta($i);
            }
        }

        foreach ($data as $colnum => &$value) {
            $value = $this->resolveCell(&$value, $this->meta[$colnum]['native_type']);
        }

        /*echo '<pre>';
        var_dump($data);
        echo '</pre>';*/
        return $data;
    }

    protected function resolveCell($data, $type) {
        switch ($type) {
            case 'int8':
            case 'int4':
            case 'int2':
                return intval($data);
            case '_varchar':
                return $this->pgVarcharArray($data);
            case '_int2':
            case '_int4':
            case '_int8':
                return $this->pgIntArray($data);
            default:
                return $data;
        }
    }

    protected function pgIntArray($pgarray) {
        $arr = explode(',',trim($pgarray, '{}()'));
        foreach ($arr as &$value) {
            $value = intval($value);
        }
        return $arr;
    }

    protected function pgVarcharArray($pgarray) {
        $pgarray = trim($pgarray, '{}()');
        //flags
        $inQuotedString = FALSE;
        $wasQuoted = FALSE;
        $isEscaped = FALSE;
        $isFirst = TRUE;
        $isLast = FALSE;

        $done = FALSE;
        $chunks = NULL;
        $charPos = 0;
        $chunkPos = 0;
        while (!$done) {
            if (!($char = $pgarray[$charPos++]))
                $done = TRUE;
            if ($isEscaped) {
                $chunks[$chunkPos] .= $char;
            } else {
                if (($char == ',' && $inQuotedString === FALSE) || $done) {
                    $isFirst = TRUE;
                    $isLast = FALSE;
                    if ($wasQuoted) {
                        $wasQuoted = FALSE;
                    } else if ($chunks[$chunkPos] == 'NULL') {
                        $chunks[$chunkPos] = NULL;
                    }
                    $chunkPos++;
                    continue;
                } else if ($char == '"') {
                    if ($isFirst) {
                        $inQuotedString = TRUE;
                        $wasQuoted = TRUE;
                    } else {
                        $inQuotedString = FALSE;
                    }
                } else if ($char == '\\') {
                    $isEscaped = TRUE;
                    continue;
                } else {
                    $chunks[$chunkPos] .= $char;
                }
            }
            // escape handling
            if ($isEscaped)
                $isEscaped = FALSE;
            if ($isFirst)
                $isFirst = FALSE;
        }
    }

}