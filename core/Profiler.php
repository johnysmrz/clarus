<?php

class Profiler {
	
	protected static $records = array();
	protected static $maxTime = 0;
	protected static $active = false;
	
	public $message = null;
	public $startTime = null;
	public $stopTime = null;
	public $startMem = null;
	public $stopMem = null;
	public $opened = null;
	
	public static function start($message) {
		if (self::$active) {
			self::$records[] = $p = new Profiler($message);
			$p->startTime = microtime(true);
			$p->startMem = memory_get_usage();
			return $p;
		} else {
			return null;
		}
	}
	
	public static function stop(&$p) {
		if ($p instanceof Profiler && self::$active) {
			$p->stopTime = microtime(true);
			$p->stopMem = memory_get_usage();
			$p->opened = false;
			if (self::$maxTime < $p->getTime()) {
				self::$maxTime = $p->getTime();
			}
		}
	}
	
	public static function setup() {
		if (isset($_GET['profiler'])) {
			switch ($_GET['profiler']) {
				case 'on':
					$_SESSION['profiler']['active'] = true;
					self::$active = true;
				break;
				default:
				case 'off':
					$_SESSION['profiler']['active'] = false;
					self::$active = false;
				break;
			}
		} else if (isset($_SESSION['profiler']['active'])) {
			switch ($_SESSION['profiler']['active']) {
				case 'on':
					self::$active = true;
				break;
				default:
				case 'off':
					self::$active = false;
				break;
			}
		} else {
			self::$active = false;
		}
	}
	
	public static function show() {
		if (self::$active == false) {
			return null;
		}
		?>
		<style>
		#profiler {
			border: 1px solid black;
			background-color: grey;
		}
		
		#profiler td.number {
			text-align: right;
			padding: 2px 0px 2px 0px;
		}
		
		#profiler td.text {
			text-align: left;
			padding: 2px 0px 2px 20px;
		}
		
		</style>
		<?php
		echo '<table id="profiler" cellspacing="4">';
		echo '<tr><th style="width: 150px">Waste Time</th><th style="width: 150px">Memory used</th><th>Message</th></tr>';
		foreach (self::$records as &$record) {
			echo '<tr>';
			echo '<td class="number">'.self::getBar($record->getTime()).number_format($record->getTime(),3,',',' ').' ms</td>';
			echo '<td class="number">'.number_format((($record->stopMem-$record->startMem)/1024),3,',',' ').' kb</td>';
			echo '<td class="text">'.$record->message.'</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	
	protected static function getBar($time) {
		$px = ($time/self::$maxTime)*180;
		if ($time < 0.8) {
			$color = '#19FF00';
		} elseif ($time < 1.5) {
			$color = '#C5FF00';
		} elseif ($time < 4) {
			$color = '#FCFF00';
		} elseif ($time < 7) {
			$color = '#FF8D00';
		} else {
			$color = '#FF0000';
		}
		return '<div style="background-color: '.$color.'; width: '.$px.'px; height: 5px;"></div>';
	}
	
	public function __construct($message) {
		$this->opened = true;
		$this->message = $message;
	}
	
	public function getTime() {
		return (($this->stopTime-$this->startTime)*1000);
	}
	
}

?>