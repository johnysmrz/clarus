<?php

/**
 * class Log provides logging errors etc to log files
 * @version 0.1
 * @author Jan "Johny" Smrz
 * @copyright GNU/GPLv3 read licence.txt
 * @package core
 */
class Log {
	
	/**
	 * log error message into file
	 *
	 * @param string $message error message
	 * @param mixed $data additional data
	 */
	final public static function error($message,$data = null) {
		self::write($message,$data,'error');
	}
	
	/**
	 * log sql error into file
	 *
	 * @param string $message error message
	 * @param integer $code sql errorno
	 * @param string $sql error sql
	 */
	final public static function sql($message,$code,$sql) {
		self::write($message,array('code'=>$code,'sql'=>$sql),'sql');
	}
	
	/**
	 * read data from log file in PATH_LOG and return them as numbered array
	 *
	 * @param string $logFile log file to read
	 * @param int $from unix timestamp to read from date
	 * @param int $to unix timestamp to read to date
	 * @return array
	 */
	public static function getLog($logFile,$from=null,$to=null) {
		$log = array();
		$f = fopen(PATH_LOG.'/'.$logFile,'r');
		while ($l = fgetcsv($f)) {
			if ($from >= $l[0] && $from !== null) {
				continue;
			}
			if ($to <= $l[0] && $to !== null) {
				continue;
			}
			$log[] = $l;
		}
		return $log;
	}
	
	/**
	 * read all log files from PATH_LOG directory
	 *
	 * @return array
	 */
	public static function getAllLogFiles() {
		$files = scandir(PATH_LOG);
		foreach ($files as $key => &$file) {
			if ($file == '..' || $file == '.') {
				unset($files[$key]);
			}
		}
		return $files;
	}
	
	/**
	 * read last X records from all log files, compare by date and return real last logs
	 *
	 * @param int $count how many lines to return
	 * @return array
	 */
	public static function tails($count = 10) {
		$tails = array();
		$lf = self::getAllLogFiles();
		foreach ($lf as $f) {
			$tails = array_merge($tails,self::tail($f,$count));
		}
		uasort($tails,'Log::sortByDate');
		return array_slice($tails,$count);
		return $tails;
	}
		
	/**
	 * read last X records specify by $count parameter from $logFile unde PATH_LOG directory
	 *
	 * @param string $logFile log file to read
	 * @param int $count records to read
	 * @return array
	 */
	public static function tail($logFile,$count = 10) {
		$log = array();
		$f = fopen(PATH_LOG.'/'.$logFile,'r');
		while ($l = fgetcsv($f)) {
			if (array_push(&$log,$l)>$count) {
				array_shift($log);
			}
		}
		return $log;
	}
	
	/**
	 * format output returned by getLog(),tail() or tails() functions to human-readable string
	 *
	 * @param array $log log data
	 * @return string
	 */
	public static function toString($log) {
		$rtn = '';
		foreach ($log as $line) {
			$rtn .= date('j.m.Y H:i:s ',$line[0]);
			$rtn .= $line[1].' ';
			$data = unserialize($line[2]);
			switch (gettype($data)) {
				case 'array':
					$rtn .= implode('|',$data);
				break;
				case 'string':
					$rtn .= $data;
				break;
				default:
					$rtn .= gettype($line[2]);
			}
			$rtn .= '<br />';
		}
		return $rtn;
	}
	
	/**
	 * provides real write to log file
	 *
	 * @param string $message log message
	 * @param mixed $data additional data
	 * @param string $type type/name of log file (withou .log)
	 */
	protected static function write($message,$data,$type) {
		$s[0] = mktime();
		$s[1] = $message;
		$s[2] = $data === null ? ' ' : serialize($data);
		
		$f = fopen(PATH_LOG.'/'.$type.'.log','a');
		fputcsv($f,$s,',','"');
		fclose($f);
	}
	
	/**
	 * help function to sort log data by date ASC
	 *
	 * @param record $a
	 * @param record $b
	 * @return int
	 */
	protected static function sortByDate($a,$b) {
		if ($a == $b) return 0;
		return ($a[0] > $b[0]) ? 1 : -1;
	}
}

?>