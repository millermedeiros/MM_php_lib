<?php

/**
 * URL Utilities
 * @author Miller Medeiros
 * @version 0.1 (2010/06/03)
 */
class URLUtils {

	//static class
	private function __construct() {}
	
	/**
	 * Get current URL
	 * IMPORTANT: won't work on IIS by default ( http://neosmart.net/blog/2006/100-apache-compliant-request_uri-for-iis-and-windows/ )
	 * @return string
	 */
	public static function getCurrentURL(){
		$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')? 'https' : 'http';
		return $protocol .'://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; 
	}
	
}
?>