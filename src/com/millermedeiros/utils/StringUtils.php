<?php 
/**
 * String utilities
 * @author Miller Medeiros
 * @version 0.5 (2010/06/16)
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
	
	/**
	 * Limit number of chars on a string
	 * @param string $text	Subject
	 * @param int $max_chars [optional]	Maximum number of chars (excluding $append)
	 * @param string $append [optional]	String to be appended at the end of cropped string if string is bigger than $max_chars.
	 * @param bool $string_html_tags [optional]	If it should remove any HTML tags from the string.
	 * @return string	Cropped string
	 */
	public static function crop($text, $max_chars = 125, $append = '&hellip;', $strip_html_tags = TRUE){
		if(strlen($text) <= $max_chars){
			return $text;
		}
		if($strip_html_tags){
			$text = self::stipHTMLTags($text);
		}
		$output = substr($text, 0, $max_chars);
		$output = substr($output, 0, strrpos($output, ' ')); //crop at last space char
		return $output . $append;
	}
	
	/**
	 * Removes everything enclosed by '<' and '>'
	 * - ported from Miller Medeiros Eclipse Monkey stripHTMLtags script
	 * @param string $str
	 * @return string	Formated string
	 */
	public static function stipHTMLTags($str){
		return preg_replace('/<[^>]*>/', '', $str); //removes everything enclosed by '<' and '>'
	}
	
	/**
	 * Replace spaces with hyphens and remove special chars
	 * - ported from Miller Medeiros Eclipse Monkey hyphenate script
	 * @param string $text
	 * @return string	Formated string
	 */
	public static function hyphenate($str){
		$str = preg_replace('/[^0-9a-zA-Z\xC0-\xFF \-]/', '', $str); //remove non-word chars
		$str = preg_replace('/([a-z\xE0-\xFF])([A-Z\xC0\xDF])/', '$1 $2', $str); //add space between camelCase text
		$str = preg_replace('/ +/', '-', $str); //replace spaces with hyphen
		$str = strtolower($str);
		$str = self::replaceAccents($str);
		return $str;
	}
	
	/**
	 * Replaces all chars with accents to regular ones
	 * - ported from Miller Medeiros AS3 StringUtils
	 * @param string str
	 * @return string	formated string
	 */
	public static function replaceAccents($str) {
		if (preg_match('/[\xC0-\xFF]/', $str)){
			$str = preg_replace('/[\xC0-\xC5]/', 'A', $str);
			$str = preg_replace('/[\xC6]/', 'AE', $str);
			$str = preg_replace('/[\xC7]/', 'C', $str);
			$str = preg_replace('/[\xC8-\xCB]/', 'E', $str);
			$str = preg_replace('/[\xCC-\xCF]/', 'I', $str);
			$str = preg_replace('/[\xD0]/', 'D', $str);
			$str = preg_replace('/[\xD1]/', 'N', $str);
			$str = preg_replace('/[\xD2-\xD6\xD8]/', 'O', $str);
			$str = preg_replace('/[\xD9-\xDC]/', 'U', $str);
			$str = preg_replace('/[\xDD]/', 'Y', $str);
			$str = preg_replace('/[\xE0-\xE5]/', 'a', $str);
			$str = preg_replace('/[\xE6]/', 'ae', $str);
			$str = preg_replace('/[\xE7]/', 'c', $str);
			$str = preg_replace('/[\xE8-\xEB]/', 'e', $str);
			$str = preg_replace('/[\xEC-\xEF]/', 'i', $str);
			$str = preg_replace('/[\xF1]/', 'n', $str);
			$str = preg_replace('/[\xF2-\xF6\xF8]/', 'o', $str);
			$str = preg_replace('/[\xF9-\xFC]/', 'u', $str);
			$str = preg_replace('/[\xFD\xFF]/', 'y', $str);
		}
		return $str;
	}
	
}

?>