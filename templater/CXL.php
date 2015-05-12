<?php

namespace clarus\templater;

class CXL {
	
	protected $parser = NULL;

	private $current = NULL;
	private $currentDepth = 1;
	private $treeRoot = NULL;

	public function __construct($xml) {
		$this->parser = xml_parser_create();
		xml_set_element_handler($this->parser, [$this, 'startElement'], [$this, 'endElement']);
		xml_set_character_data_handler($this->parser, [$this, 'dataHandler']);
		xml_parse($this->parser, $xml);
		var_dump($this->treeRoot);
	}

	public function createHtmlDocument(array $values) {
		ob_start();
		echo $this->treeRoot->getOutput();
		return ob_get_clean();
	}

	public function startElement($parser, $name, $attributes) {
		//printf("Start > %s\n", $name);
		if($name == 'LAYOUT') return;
		$n = explode(':', $name);
		if(sizeof($n) == 2 && $n[0] == 'CXL') {
			list($ns, $name) = explode(':', $name);
		} else {
			$ns = NULL;
		}

		switch ($ns) {
			case 'CXL':
				$el = new internal\Block($name, $attributes, $this->currentDepth);
				break;
			default:
				$el = new internal\HtmlElement($name, $attributes, $this->currentDepth);
		}
		
		if($this->treeRoot == NULL) {
			$this->treeRoot = $el;
		} else {
			if($this->current instanceof internal\Element) {
				$this->current->addData($el);
			}
		}

		$el->parent = $this->current;
		$this->current = $el;
		$this->currentDepth++;
	}

	public function endElement($parser, $name) {
		if($name == 'LAYOUT') return;
		$this->current = $this->current->parent;
		$this->currentDepth--;
	}

	public function dataHandler($parser, $data) {
		$data = trim($data);
		if(strlen($data)) {
			if($this->current instanceof internal\Element) {
				$this->current->addData($data);
			}
		}
	}

}























