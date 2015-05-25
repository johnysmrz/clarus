<?php

namespace clarus\db\simple;

class QueryBuilder {

	const INSERT = 'INSERT';
	const UPDATE = 'UPDATE';

	const FLAG_RAW = 1;

	protected $table = NULL;
	protected $data = [];
	protected $operation = NULL;
	
	public function __construct() {

	}

	public function insert($tbl) {
		$this->table = $tbl;
		$this->operation = self::INSERT;
		return $this;
	}

	public function update($tbl) {
		$this->table = $tbl;
		$this->operation = self::UPDATE;
		return $this;
	}

	public function data(array $data = []) {
		foreach ($data as $key => $value) {
			$this->add($key, $value, 0);
		}
		return $this;
	}

	public function add($colName, $value, $flag = 0) {
		$bindName = sprintf(':par_%s', mb_strtolower($colName));
		$this->data[] = [$colName, $value, $bindName, $flag];
	}

	public function getSql() {
		if($this->table === NULL) throw new \LogicException('No table name providet.');
		if($this->data === NULL) throw new \LogicException('No data for builder providet.');
		$rtn = '';
		switch ($this->operation) {
			case self::INSERT:
				$rtn .= sprintf("INSERT INTO\n\t%s\nSET\n", $this->table);
				break;
			case self::UPDATE:
				$rtn .= sprintf("UPDATE\n\t%s\nSET\n", $this->table);
				break;
			default:
				throw new \LogicException('No method (insert/update) provided.');
				break;
		}

		$rows = [];
		foreach ($this->data as $v) {
			if($v[3] == 0) {
				$rows[] = sprintf("\t%s = %s", $v[0], $v[2]);
			} else {
				$rows[] = sprintf("\t%s = %s", $v[0], $v[1]);
			}
		}

		$rtn .= implode(",\n", $rows);
		
		return $rtn;
	}

	public function getBinds() {
		$rtn = [];
		foreach ($this->data as $v) {
			if($v[3] == 0) {
				$rtn[$v[2]] = $v[1];
			}
		}
		return $rtn;
	}

}