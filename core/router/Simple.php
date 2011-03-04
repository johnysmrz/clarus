<?php

class router_Simple extends router_Router {

    protected $pattern = NULL;

    public function __construct($pattern, $flags = NULL) {
        $this->pattern = $pattern;
        parent::__construct($flags);
    }

    public function match() {
	preg_match_all('~<[a-z]+>~', $pattern, $matches, PREG_OFFSET_CAPTURE);

	echo '<pre>' . print_r($matches, true) . '</pre>';

	$newPattern = '';
	$start = 0;

	foreach ($matches[0] as $match) {
	    $newPattern .= self::escapeNonPregString(substr($pattern, $start, ($match[1] - $start)));
	    $newPattern .= '([a-z]+)';
	    $start = ($match[1] + strlen($match[0]));
	}

	$newPattern = '~'.$newPattern.'~';

	if(preg_match($newPattern, $_SERVER['REQUEST_URI'], $matches)) {
	    $this->isMatch = 1;
	}
        return TRUE;
    }

}

?>
