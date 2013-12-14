<?php 
/**
 * @author Kaio Cesar <tecnico.kaio@gmail.com>
 * @package Miniframework
 * @version 1.0	
 */

class library_auth2_auth {

	private static $modules_auth = 'admin';

	private static $instance;

	private function __construct() {}

	public static function singleton () {
		if (! isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}

		return self::$instance;

	}

	/**
	 * Getter's and Setter's
	 */
	public function setModulesAuth($modules=null) {
		if (! is_null($modules))
		self::$modules_auth = $modules;
	}


	/**
	 * Check Authentication
	 */
	public static function checkAuthentication() {
		/**
		 * user + senha
		 */
	}


	/**
	 * Init Session
	 */
	public static function initSession() {}


	/**
	 * Verify Session
	 */
	public static function verifySession() {}	


	/**
	 * Clean Session
	 */
	public static function cleanSession() {
		session_destroy();
	}


	/**
	 *  Verify USER NAME
	 */
	public static function verifyUserName($username=null) {
		if ((is_null($username))) return false;
	}



}
