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
	 * XXX: maybe implement option to return the result as string instead of displaying it (not sure if needed since can use the output buffer for it outside the class).
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