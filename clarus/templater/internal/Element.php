<?php

namespace clarus\templater\internal;

abstract class Element {

	protected $container = [];
	protected $attributes = [];
	protected $name = NULL;
	public $parent = NULL;
	protected $depth = 0;

	public function __construct($name, array $attributes = [], $depth = 0) {
		$this->name = $name;
		$this->attributes = $attributes;
	}

	public function addData($data) {
		$this->container[] = $data;
	}

	public function getOutput() {
		$out = sprintf("%s<%s>\n", str_repeat(" ", $this->depth * 2), strtolower($this->name));
		foreach ($this->container as $v) {
			if($v instanceof Element) {
				$out .= $v->getOutput();
			} else {
				$out .= $v."\n";
			}
		}
		$out .= sprintf("%s</%s>\n", str_repeat(" ", $this->depth * 2), strtolower($this->name));
		return $out;
	}

}