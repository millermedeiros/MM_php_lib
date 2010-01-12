<?php

/**
 * Simple caching system
 * @author Miller Medeiros
 * @version 0.2 (2010/01/12)
 */
class SimpleCaching {
	
	private $max_age;
	
	private $cached_file_path;
	
	/**
	 * Creates a new SimpleCaching Object.
	 * @param object $max_age	Maximum amount of time in seconds that an page will be considered "fresh".
	 * @param object $output_directory	Full path to the directory that will store cached files.
	 * @param object $file_id [optional]	ID used to allow more than one cache file per `REQUEST_URI`.
	 * @return 
	 */ 
	function __construct($max_age, $output_directory, $file_id = ''){
		$this->max_age = $max_age;
		
		$request_url = $_SERVER['REQUEST_URI'];
		$request_url .= (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '')? '?'. $_SERVER['QUERY_STRING'] : '';
		
		$file_name = md5($request_url . $file_id);
		$path = realpath($output_directory) .'/'. $file_name;
		
		$this->cached_file_path = str_replace('\\', '/', $path);
	}
	
	/**
	 * Start buffering the output. 
	 * - Should be called just before output that needs to be cached.
	 */
	public function start(){
		ob_end_flush(); //flushes buffer before to avoid caching unnecessary content.
		ob_start();
	}
	
	/**
	 * Create cache file. 
	 * - Should be called after output that needs to be cached.
	 * - It won't throw any error if it can't write the cache file, you should check return for handling errors.
	 * @return bool	If cache file was created.
	 */
	public function save(){
		$fp = fopen($this->cached_file_path, 'w+');
		$bytes = @fwrite($fp, ob_get_contents());
		fclose($fp);
		ob_end_flush();
		return (bool) $bytes;
	}
	
	/**
	 * Check if cache file exists and if it needs to be updated.
	 * @return bool If file is already cached. 
	 */
	public function isCached(){
		return (file_exists($this->cached_file_path) && time() < filemtime($this->cached_file_path) + $this->max_age);
	}
	
	/**
	 * Load cached file if it exists and output it.
	 * - If cache doesn't exist it won't throw any error, you should check return for handling errors.
	 * @return bool	If cache file was loaded.
	 */
	public function load(){
		$bytes = @readfile($this->cached_file_path);
		ob_end_flush();
		return (bool) $bytes;
	}
	
}
?>