<?php

/**
 * Helper Class for retrieving data from $_GET, $_POST, $_COOKIE, etc..
 * - Static Class
 * @author Miller Medeiros
 * @version 0.1 (2010/06/02)
 */
class SuperglobalsHelper {

	// Static Class
	private function __construct() {}
	
	/**
	 * Retrieves the value of a variable contained on the $_GET superglobal
	 * @param string $var_name	Variable name
	 * @return mixed	Value or FALSE if var doesn't exist
	 */
	public static function get($var_name){
		return isset($_GET[$var_name])? $_GET[$var_name] : FALSE; 
	}
	
	/**
	 * Retrieves the value of a variable contained on the $_POST superglobal
	 * @param string $var_name	Variable name
	 * @return mixed	Value or FALSE if var doesn't exist
	 */
	public static function post($var_name){
		return isset($_POST[$var_name])? $_POST[$var_name] : FALSE; 
	}
	
	/**
	 * Retrieves the value of a variable contained on the $_COOKIE superglobal
	 * @param string $var_name	Variable name
	 * @return mixed	Value or FALSE if var doesn't exist
	 */
	public static function cookie($var_name){
		return isset($_COOKIE[$var_name])? $_COOKIE[$var_name] : FALSE; 
	}
	
	/**
	 * Retrieves the value of a variable contained on the $_SESSION superglobal
	 * @param string $var_name	Variable name
	 * @return mixed	Value or FALSE if var doesn't exist
	 */
	public static function session($var_name){
		return isset($_SESSION[$var_name])? $_SESSION[$var_name] : FALSE; 
	}
	
	/**
	 * Retrieves the value of a variable contained on the $_SERVER superglobal
	 * @param string $var_name	Variable name
	 * @return mixed	Value or FALSE if var doesn't exist
	 */
	public static function server($var_name){
		return isset($_SERVER[$var_name])? $_SERVER[$var_name] : FALSE; 
	}
	
}
?>