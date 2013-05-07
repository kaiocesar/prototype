<?php
/**
 * Controller - Library
 * @author Kaio Cesar <tecnico.kaio@gmail.com>
 * @package app/library
 */

class library_Controller extends library_View{
	
	public $title_page = "";
    
    private static $instance;

    private function __construct() {}

    public static function singleton($classname=null) {
    	if (! isset(self::$instance)) {
    		self::$instance = new $classname;
    	}
    	return self::$instance;
    }


    public static function is_post() {
        if ( ($_POST) && (isset($_POST)) ) 
            return true;
        else 
            return false;
    }

    public static function is_get() {
        if ( ($_GET) && (isset($_GET)) ) 
            return true;
        else 
            return false;
    }
    

    public function __call($name, $arguments) {
        // return get_class_methods(self::singleton(__CLASS__));
        // redirect for 404 page
        return '404';
    }    

    public function Error() {
        echo 'P&aacute;gina n&atilde;o encontrada';
    }


}