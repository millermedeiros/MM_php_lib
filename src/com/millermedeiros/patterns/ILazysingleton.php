<?php
/**
 * Interface for Singleton classes the uses LazySingleton instantiation.
 * @author Miller Medeiros (htt://www.millermedeiros.com)
 * @version 1.0 (2009/12/17)
 */
interface ILazySingleton {
	/**
	 * Should call LazySingleton::validate(__CLASS__) before starting the Class construction.
	 */
	function __construct();
	/**
	 * Should call LazySingleton::getInstance(__CLASS__)
	 * @return object instance
	 */
	static function getInstance();
	/**
	 * Prevents object clone (should trigger_error) if called or at least don't do anything.
	 */
	function __clone();
}
?>