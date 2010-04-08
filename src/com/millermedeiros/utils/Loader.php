<?php

/**
 * Helper Class to load (include) external files [static class]
 * @author Miller Medeiros
 * @version 0.2 (2010/04/07)
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
	 * Load Template File
	 * - replace variables wrapped in '::' with the $data item with same key.  
	 * TODO: add option to load Template files that contain PHP code and also option to set a custom delimiter for vars. 
	 * @param string $file_path	Path to the desired file
	 * @param array $data [optional]	Array or Object with data that should be passed to the loaded file [ex: $data = array('foo' => 'lorem', 'bar' => 'ipsum')]
	 */
	public static function loadTemplate($file_path, $data = NULL){
		$output = file_get_contents($file_path);
		if(isset($data)){
			foreach($data as $key=>$value){
				$output = preg_replace("/::$key::/", $value, $output); //replace everything between '::' with the proper value 
			}
		}
		echo $output;
	}
	
}
?>