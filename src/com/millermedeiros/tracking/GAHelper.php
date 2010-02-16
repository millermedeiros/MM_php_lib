<?php

/**
 * Helper Methods for Google Analytics tracking
 * @author	Miller Medeiros (www.millermedeiros.com)
 * @version	0.1 (2010/02/12)
 */
class GAHelper {

	/**
	 * Static Class
	 * @private 
	 */
	private function __construct(){}
	private function __clone(){}
	
	/**
	 * Get Google Analytics image based on GA user account.
	 * - based on GA mobile sample files.
	 * @param string	$ga_php_file_url	Full path to the 'ga.php' file (should be stored on the root folder of the application)
	 * @param string	$ga_account_id	Google Analytics account ID (ex: 'UA-5555-55555')
	 * @param bool	$is_debug [optional]	If GA should throw errors (only set to TRUE during development)
	 * @return string	Tracking image URL 
	 */
	public static function getImageUrl($ga_php_file_url, $ga_account_id, $is_debug = FALSE){
		$url = '';
		$url .= $ga_php_file_url . '?';
		$url .= 'utmac=' . $ga_account_id;
		$url .= '&utmn=' . rand(0, 0x7fffffff);
		
		$referer = @$_SERVER["HTTP_REFERER"]; //@ suppress errors (sometimes HTTP_REFERER doesn't exist)
		$referer = (empty($referer))? '-' : $referer;
		$url .= '&utmr=' . urlencode($referer);
		
		$path = $_SERVER["REQUEST_URI"];
		$url .= (!empty($path))? '&utmp=' . urlencode($path) : '';
		
		$url .= '&guid=ON';
		
		$url .= ($is_debug)? '&utmdebug=TRUE' : ''; //add debug
		
		$url = str_replace('&', '&amp;', $url); //to validate HTML
		return $url;
  }
	
}
?>