<?php 
/**
 * String utilities
 * @author Miller Medeiros
 * @version 0.3 (2010/02/23)
 */
class StringUtils {
	
	/**
	 * Constructor - Static Class
	 * @private
	 */
	private function __construct(){}
	
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
		$output = preg_replace('/\-+|\_+/', ' ', $output); // replace '-' and '_' with spaces
		$output = ucwords($output);
		return htmlentities($output);
	}
	
}

?>