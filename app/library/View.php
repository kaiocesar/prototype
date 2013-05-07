<?php 
/**
 * 	View - Class helper rendireze view template
 *	@author Kaio Cesar <tecnico.kaio@gmail.com>
 *
 */

class library_View extends library_filterUrl {

	public static function Make($fileView=null) {
		$exp = explode(".",$fileView);
		$path = APP_PATH . "modules/". self::$routes['module'] ."/views/". $exp[0] ."/" . $exp[1] . '.php';
		if (file_exists($path))
			include_once($path);
		else
			echo "<h1>404</h1>";
	}

}
