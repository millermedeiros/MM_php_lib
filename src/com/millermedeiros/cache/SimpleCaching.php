<?php

/**
 * Simple caching system
 * @author Miller Medeiros
 * @version 0.3 (2010/05/12)
 */
class SimpleCaching {
	
	/**
	 * @var int	Cache file maximum age in seconds.
	 */
	public $max_age;
	
	/**
	 * @var string Path to the cached file.
	 */
	private $cached_file_path;
	
	/**
	 * Creates a new SimpleCaching Object.
	 * @param int $max_age	Maximum amount of time in seconds that an page will be considered "fresh".
	 * @param string $output_directory	Full path to the directory that will store cached files.
	 * @param string $cache_id [optional]	ID used to allow more than one cache file per `REQUEST_URI`.
	 * @param bool $ignore_request [optional]	If it should ignore REQUEST_URI while generating cached file name.
	 * @param bool $ignore_query_string [optional]	If it should ignore QUERY_STRING while generating cached file name.
	 */ 
	function __construct($max_age, $output_directory, $cache_id = '', $ignore_request = FALSE, $ignore_query_string = FALSE){
		$this->max_age = $max_age;
		
		$request_url = '';
		
		if(! $ignore_request){
			$request_url .= $_SERVER['REQUEST_URI'];
		}
		if(! $ignore_query_string){
			$request_url .= (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '')? '?'. $_SERVER['QUERY_STRING'] : '';
		}
		
		$file_name = md5($request_url . $cache_id);
		$path = realpath($output_directory) .'/'. $file_name;
		
		$this->cached_file_path = str_replace('\\', '/', $path);
	}
	
	/**
	 * Start buffering the output. 
	 * - Should be called just before output that needs to be cached.
	 * @return bool If output buffer was started
	 */
	public function start(){
		return ob_start();
	}

	/**
	 * Save cache file. 
	 * - Should be called after output that needs to be cached.
	 * - It won't throw any error if it can't write the cache file, you should check return for handling errors.
	 * @return bool	If stored anything inside cache file.
	 */
	public function save(){
		$fp = fopen($this->cached_file_path, 'w+');
		$bytes = @fwrite($fp, ob_get_contents());
		fclose($fp);
		ob_end_flush();
		return (bool) $bytes;
	}
	
	/**
	 * Load cached file if it exists and output it.
	 * - If cache doesn't exist it won't throw any error, you should check return for handling errors.
	 * @return bool	If cache file was loaded.
	 */
	public function load(){
		$bytes = @readfile($this->cached_file_path);
		return (bool) $bytes;
	}
	
	/**
	 * Check if cache file exists.
	 * @return bool If file cache file exists. 
	 */
	public function isCached(){
		return file_exists($this->cached_file_path);
	}
	
	/**
	 * Check if cache file exist and didn't expired.
	 * - returns FALSE if file doesn't exist of if file age is bigger than $max_age.
	 * @return bool If cache still valid.
	 */
	public function isValid(){
		return ($this->isCached() && time() < filemtime($this->cached_file_path) + $this->max_age);
	}
	
	/**
	 * Get path to the cached file
	 * @return string	Cached file path
	 */
	public function getCachedFilePath(){
		return $this->cached_file_path;
	}
	
	//---- debug
	
	/**
	 * Output info related to the cache
	 */
	public function debug(){
		echo 'current time: '. time() .'<br />';
		echo 'cached_file_path: '. $this->cached_file_path .'<br />';
		echo 'isCached: '. $this->isCached() .'<br />';
		echo 'isValid: '. $this->isValid() .'<br />';
		if($this->isCached()){
			echo 'cached filemtime: '. filemtime($this->cached_file_path) .'<br />';
		}
		echo 'max_age: '. $this->max_age .'<br />';
	}
	
}
?>