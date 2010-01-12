<?php
/**
 * Parse files and output minified version
 * @author Miller Medeiros
 * @version 0.1.2 (2009/12/09)
 */
class MMCompressor {
	
	//TODO: add compressJS method
	
	/**
	 * Constructor - Static Class
	 * @private
	 */
	private function __construct(){}
	
	/**
	 * Compress CSS File - Strip comments and remove unnecessary empty spaces, line breaks, tabs, etc.
	 * @param string $css_string	Style Sheet string.
	 * @param bool $preserve_semicolons [optional]	If it should preserve & add unnecessary semicolons right before a '}'.
	 * @return string	Compressed Style Sheet.
	 */
	public static function compressCSS($css_string, $preserve_semicolons = FALSE){
		
		$output = preg_replace('/\t|\r|\n|( {2,})/', '', $css_string); //remove tabs, line breaks and multiple spaces
		$output = preg_replace('/( +)?(?<=;|,|:)( +)?/', '', $output); //remove unnecessary spaces around ';' and ',' and ':'
		$output = preg_replace('/ {/', '{', $output); //remove unnecessary space before '{'
		$output = preg_replace('/\/\*.+?(?:\*\/)/', '', $output); //strip comments
		if($preserve_semicolons){
			$output = preg_replace('/(?<=[^{;])}/', ';}', $output); //add unnecessary ';' before '}'
		}else{
			$output = preg_replace('/;}/', '}', $output); //remove unnecessary ';' before '}'
		}
		return $output;
	}
	
	/**
	 * Compress HTML file - Strip comments, remove tabs and line breaks.
	 * @param string $html_string	HTML string.
	 * @param bool $preserve_comments [optional]	If it should preserve comments.
	 * @param bool $preserve_linebreaks [optional]	If it should preserve line breaks.
	 * @return string	Compressed HTML.
	 */
	public static function compressHTML($html_string, $preserve_comments = FALSE, $preserve_linebreaks = FALSE){
		$output = preg_replace('/\t+/', '', $html_string);
		if(! $preserve_comments){
			$output = preg_replace('/<!--[\s\S]*-->/', '', $output); //strip comments
		}
		if(! $preserve_linebreaks){
			$output = preg_replace('/\r|\n/', '', $output); //remove line breaks
		}
		return $output;
	}
	
}
?>