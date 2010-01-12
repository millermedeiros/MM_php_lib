<?php

/**
 * Class to deal with security issues related to URLRequests
 * @author Miller Medeiros (www.millermedeiros.com)
 * @version 0.1 (2009/12/23)
 */
class URLRequest {

    private function __construct() {}
	
	/**
	 * Block Attack using malicious URL Requests
	 * - based on: http://perishablepress.com/press/2009/12/22/protect-wordpress-against-malicious-url-requests/
	 * maybe add other things from the BlackList (http://perishablepress.com/press/2009/03/16/the-perishable-press-4g-blacklist/)
	 */
	public static function blockBadQueries(){
		
		if (strlen($_SERVER['REQUEST_URI']) > 255 || strpos($_SERVER['REQUEST_URI'], "eval(") || strpos($_SERVER['REQUEST_URI'], "base64")){
			@header("HTTP/1.1 414 Request-URI Too Long");
			@header("Status: 414 Request-URI Too Long");
			@header("Connection: Close");
			exit("HTTP/1.1 414 Request-URI Too Long");
		}
		
	}
	
}

?>