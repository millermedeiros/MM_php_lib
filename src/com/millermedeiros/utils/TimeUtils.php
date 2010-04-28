<?php

/**
 * Helper Class to deal with time units
 * @author Miller Medeiros
 * @version 0.1.2 (2010/04/21)
 */
class TimeUtils{
	
	// seconds time table (rounded values)
	const MILLISECOND = 0.001;
	const SECOND = 1;
	const MINUTE = 60;
	const HOUR = 3600;
	const DAY = 86400;
	const WEEK = 604800;
	const MONTH = 2629800;
	const YEAR = 31557600;
	
	/**
	 * @private Static Class 
	 */
	private function __construct(){}
	
	/*-- Methods --*/
	
	/**
	 * Convert seconds to approximate string Time (rounded units)
	 * @param int $s	Seconds  
	 * @return string	Rounded value (eg: "3 days"), minimum value is "1 second".
	 */
	public static function secondToPeriod($s){
		$output = '';
		
		//ordered from bigger to smaller
		$periods = array(
			array('year', 'years', self::YEAR),
			array('month', 'months', self::MONTH),
			array('week', 'weeks', self::WEEK),
			array('day', 'days', self::DAY),
			array('hour', 'hours', self::HOUR),
			array('minute', 'minutes', self::MINUTE),
			array('second', 'seconds', self::SECOND)
		);
		
		if($s < 1){
			$s = 1;
		}
		
		$n = count($periods);
		$period;
		
		for($i = 0; $i < $n; $i++){
			$period = $periods[$i];
			if($s >= $period[2]){
				$n_periods = round($s / $period[2]);
				$output = $n_periods .' ';
				$output .= ($n_periods <= 1)? $period[0] : $period[1];
				break;
			}
		}
		
		return $output;
	}
	
}

?>