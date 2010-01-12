<?php

/**
 * Simple test of the caching system
 * @author Miller Medeiros
 * @version 0.1
 */
    
	error_reporting(E_STRICT);
	
	$root_path = realpath(dirname(__FILE__)) .'/';
	$root_path = preg_replace('/\\\\/', '/', $root_path); //replace all '\' with '/'
	
	require_once $root_path . 'SimpleCaching.php';
	
	
	
	//-- uncached content  before
	
	echo PHP_EOL . '<p>uncached content before: '. rand(0, 0xFFFFFF) .'</p>'. PHP_EOL . PHP_EOL;
	
	
	
	//-- start cache 1
	
	$cache1 = new SimpleCaching(10, $root_path .'../cache/', 'content1');
	
	//should check if cache exist before creating a new file.
	if($cache1->isCached()){
		$cache1->load(); //load file from cache
	}else{
		//execute code if not cached
		
		$cache1->start(); //start caching output
	
		//content that will be cached
		echo 'Lorem ipsum dolor sit amet. <br />';
		echo PHP_EOL;
		echo 'Maecennas!!';
		echo 'generated: '. time() . '<br />'. PHP_EOL;
		
		$cache1->save(); //ends caching and generate cache file
	}




	//-- uncached content between
	
	echo PHP_EOL . '<p>uncached content between: '. rand(0, 0xFFFFFF) .'</p>'. PHP_EOL . PHP_EOL;
	
	
	
	
	//-- start second cache
	
	$cache2 = new SimpleCaching(10, $root_path .'../cache/', 'content2');
	
	//should check if cache exist before creating a new file.
	if($cache2->isCached()){
		$cache2->load(); //load file from cache
	}else{
		$cache2->start(); //start caching output
		
		//content that will be cached
		echo 'content 2. <br />';
		echo PHP_EOL;
		echo 'generated: '. time() . '<br />'. PHP_EOL;
		
		$cache2->save(); //ends caching and generate cache file
	}
	
	
	
	//-- uncached content after
	
	echo PHP_EOL . '<p>uncached content after: '. rand(0, 0xFFFFFF) .'</p>'. PHP_EOL . PHP_EOL;
	
	
?>