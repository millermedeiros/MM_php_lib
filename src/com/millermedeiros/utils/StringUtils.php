<?php 
/**
 * String utilities
 * @author Miller Medeiros
 * @version 0.2 (2009/12/18)
 */
class StringUtils {
	
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
	 * Convert path string into a search engine friendly string
	 *  - ex: StringUtils::toTitleFormat('/lorem/ipsum-dolor/', 'Default Page Title') returns 'Ipsum Dolor | Lorem | Default Page Title'.
	 * @param string $path Url path
	 * @param string $default_title [optional] 
	 * @param object $separator [optional] Char used to separate path names
	 * @return string Formated string
	 */
	public static function toTitleFormat($path, $default_title = '', $separator = ' | '){
		$output = '';
		$paths_arr = explode('/', $path);
		$n = count($paths_arr);
		while($n--){
			$output .= ($paths_arr[$n] != '')? $paths_arr[$n] . $separator : '';
		}
		$output .= $default_title;
		$output = preg_replace('/\-|\_/', ' ', $output);
		$output = ucwords($output);
		return $output;
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
		
		$current_folder = (isset($current_folder))? $current_folder : $_SERVER['REQUEST_URI'];
		
		$current_folder = str_replace($base_folder, '', $current_folder);
		$current_folder = preg_replace('/^\/|\/$/', '', $current_folder);
		
		if(!$current_folder || $current_folder == '/' || $current_folder == './'){
			$relative_root = './';
		} else if(!preg_match('/^\.*\/$/', $current_folder)){ //check if $current_folder != '/' && './' && '../' 
			$folders = explode('/', $current_folder);
			$folder_depth = count( $folders );
			//TODO: maybe change to a Regex instead of a loop. (don't know why I used the loop..)
			while($folder_depth--){
				$relative_root .= '../';
			}
		}else{
			$relative_root = $current_folder;
		}
		return $relative_root;
	}
	
}

?>