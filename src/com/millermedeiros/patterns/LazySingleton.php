<?php

/**
 * Singleton Factory - based on Francis Turmel (http://www.nectere.ca) AS3 implementation
 * @author Miller Medeiros (http://www.millermedeiros.com)
 * @version 1.0 (2009/12/17)
 */
class LazySingleton {
	
	private static $_references = array();
	private static $_allowBuild = array();
	
    private function __construct() {}
	
	/**
	 * Get Object instance.
	 * @param string $class_name Class name (can be retrieved using '__CLASS__' constant).
	 * @return object Instance
	 */
	public static function getInstance($class_name){
		if(!array_key_exists($class_name, self::$_references)) {
			self::$_allowBuild[$class_name] = TRUE;
			self::$_references[$class_name] = new $class_name();
			unset( self::$_allowBuild[$class_name] );
		}
		return self::$_references[$class_name];
	}
	
	/**
	 * Check if the Class was instantiated using the getInstance() method.
	 * @param object $class_name Class name.
	 */
	public static function validate($class_name){
		if(! isset(self::$_allowBuild[$class_name]) || isset(self::$_references[$class_name]) ){
			trigger_error("$class_name is a Singleton Class and can only be instantiaded using the getInstance() method.", E_USER_ERROR);
		}
	}
	
}
?>