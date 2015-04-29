<?php

namespace clarus\templater;

class XML {
	
	protected $parser = NULL;

	protected $htmlOutput = '';

	public function __construct($xml) {
		$this->parser = xml_parser_create();
		xml_set_element_handler($this->parser, array($this, 'startElement'), array($this, 'endElement'));
		xml_set_character_data_handler($this->parser, array($this, 'dataHandler'));
		xml_parse($this->parser, $xml);
	}

	public function createHtmlDocument(array $values) {
		ob_start();
		echo "<html>\n";
		echo "<head>";
		echo $this->htmlOutput;
		echo "</head>\n";
		echo "</html>";
		return ob_get_clean();
	}

	public function startElement($parser, $name, $attributes) {
		if(substr($name, 0, 5) == 'HTML:') {
			$this->htmlOutput .= '<'.mb_strtolower(mb_substr($name, 5));
			foreach ($attributes as $key => $value) {
				$this->htmlOutput .= ' '.mb_strtolower($key).'="'.$value.'"';
			}
			$this->htmlOutput .= '>';
		}
		if ($name == 'VARIABLE') {
			$this->htmlOutput .= $attributes['DEFAULT'];
		}
	}

	public function endElement($parser, $name) {
		if(substr($name, 0, 5) == 'HTML:') {
			$this->htmlOutput .= '</'.mb_strtolower(mb_substr($name, 5)).'>';
		}
	}

	public function dataHandler($parser, $data) {
		$this->htmlOutput .= $data;
	}

}