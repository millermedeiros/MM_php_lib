<?php

/**
 * Helper Class to load (include) external files [static class]
 * @author Miller Medeiros
 * @version 0.3 (2010/04/15)
 */
class Loader {

    private function __construct() {}
	
	/**
	 * Load external file and assign variables
	 * @param string $file_path	Path to the desired file
	 * @param array $data [optional]	Array or Object with data that should be passed to the loaded file [ex: $data = array('foo' => 'lorem', 'bar' => 'ipsum')]
	 */
	public static function load($file_path, $data = NULL){
		if(isset($data)){
			foreach($data as $key=>$value){
				$$key = $value; //set variables inside this method scope (same scope as the included file)
			}
		}
		include $file_path;
	}
	
	/**
	 * Load Simple Template File
	 * - only replace variables wrapped in '::' with the $data item with same key.
	 * - if you need loops and conditionals just use regular PHP and set '$execute_php' to TRUE.
	 * - don't use the loadTemplate method inside a template.
	 * TODO: add option to set a custom delimiter for vars.
	 * TODO: add option to escape '::'.
	 * @param string $file_path	Path to the desired file
	 * @param array $data [optional]	Array or Object with data that should be passed to the loaded file [ex: $data = array('foo' => 'lorem', 'bar' => 'ipsum')]
	 * @param bool	$execute_php [optional]	If PHP code inside template should be executed.
	 */
	public static function loadTemplate($file_path, $data = NULL, $execute_php = FALSE){
		
		if($execute_php){
			@ ob_end_flush(); //flushes buffer to avoid caching unnecessary content. (suppress error in case there's no buffer to flush)
			ob_start();
			self::load($file_path, $data);
			$output = ob_get_clean();
		}else{
			$output = file_get_contents($file_path);	
		}
		
		if(isset($data)){
			foreach($data as $key=>$value){
				$output = preg_replace("/::$key::/", $value, $output); //replace everything between '::' with the proper value 
			}
		}
		echo $output;
	}
	
}
?>