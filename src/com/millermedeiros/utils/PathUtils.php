<?php
/**
 * Path utilities
 * @author Miller Medeiros
 * @version 0.1 (2010/02/23)
 */
class PathUtils {

	/**
	 * Constructor - Static Class
	 * @private
	 */
	private function __construct(){}
	
	/**
	 * Remove all duplicated '/' except after ':' (because of "http://" and "file:///") and convert all '\' to '/'
	 * @param string $path Path or URL
	 * @return string Formated string
	 */
	public static function sanitizePath($path){
		$output = '';
		$output = preg_replace('/(?<!:)\/{2,}|\\\\+/', '/', $path); //replace '//' and '\+' with '/' (unless '//' comes after ':')
		$output = preg_replace('/^\//', '', $output); //remove '/' from the beginning of the string
		return $output;
	}
	
	/**
	 * Convert relative path into canonicalized absolute pathname (calls PHP realpath method + PathUtils::sanitizePath).
	 * @param string $path	Path to be checked.
	 * @return string|bool	Canonicalized absolute pathname or FALSE on failure, e.g. if file doesn't exist.
	 */
	public static function toRealPath($path){
		$real_path = '';
		$real_path = realpath($path);
		if(! $real_path){ //realpath() returns FALSE if path doesn't exist
			return FALSE;
		}
		$real_path = self::sanitizePath($real_path);
		return $real_path;
	}
	
	/**
	 * Get relative path to a parent folder.
	 * - ex: StringUtils::getRelativeRoot('/lorem/ipsum/dolor/', '/lorem/') -> returns '../../'. 
	 * @param string $current_folder [optional]	Current folder path (ex: '/lorem/ipsum/dolor') uses $_SERVER['REQUEST_URI'] by default.
	 * @param string $base_folder [optional]	Root folder path (ex: '/lorem/').
	 * @return string	Relative path to the $base_folder.
	 */
	public static function getRelativeRoot($current_folder = NULL, $base_folder = ''){
		$relative_root = '';
		
		$current_folder = (isset($current_folder))? $current_folder : @$_SERVER['REQUEST_URI']; // @ suppress errors if REQUEST_URI doesn't exist
		
		$current_folder = str_replace($base_folder, '', $current_folder);
		$current_folder = preg_replace('/^\/|\/$/', '', $current_folder); // removes '/' from beginning and end of string
		
		if(!$current_folder || $current_folder == '/' || $current_folder == './'){
			$relative_root = './';
		} else if(preg_match('/^(\.\.\/)+$/', $current_folder)){ // check if folder is already a relative path to root '../+' 
			$relative_root = $current_folder;
		} else{
			$relative_root = preg_replace('/[^\/]+\/?/', '../', $current_folder); // add '../' for each path depth
		}
		return $relative_root;
	}
	
}
?>