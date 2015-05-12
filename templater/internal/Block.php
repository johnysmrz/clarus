<?php

namespace clarus\templater\internal;

class Block extends Element {
	
	public function getOutput() {
		$out = sprintf("<!-- BLOCK: %s -->\n", isset($this->attributes['NAME']) ? $this->attributes['NAME'] : 'UNKNOWN');
		foreach ($this->container as $v) {
			if($v instanceof Element) {
				$out .= $v->getOutput();
			} else {
				$out .= $v."\n";
			}
		}
		$out .= sprintf("<!-- END: %s -->\n", isset($this->attributes['NAME']) ? $this->attributes['NAME'] : 'UNKNOWN');
		return $out;		
	}

}