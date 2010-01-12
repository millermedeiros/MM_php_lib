<?php

/**
 * Helper Class to load (include) external files [static class]
 * @author Miller Medeiros
 * @version 0.1 (2009/12/17)
 */
class Loader {

    private function __construct() {}
	
	/**
	 * Load external file and assign variables
	 * TODO: implement option to return the result instead of displaying it (maybe as an output buffer object - so we have more option to get the content as string or to flush the buffer).
	 * TODO: implement basic templating system (probably just simple var replacements - no fancy loops).
	 * @param string $file_path	Path to the desired file
	 * @param array [$data]	Array or Object with data that should be passed to the loaded file [ex: $data = array('foo' => 'lorem', 'bar' => 'ipsum')]
	 */
	public static function load($file_path, $data = NULL){
		if(isset($data)){
			foreach($data as $key=>$value){
				$$key = $value; //set variables inside this method scope (same scope as the included file)
			}
		}
		include $file_path;
	}
	
}
?>