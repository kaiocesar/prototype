<?php
/**
 * Class filter url - library
 * @package
 * @author Kaio Cesar
 * @version 1.0
 */

class library_filterUrl extends library_utils {
	/**
	 * @var array $url
	 */
	protected static $routes = array(
        'module' => 'default',
        'controller' => 'Index',
        'action' => 'Index'
    );
    
	/**
	 * @var array $modules
	 */
	protected static $modules = array('default','admin');
    
    /**
     * @var Params
     */
    protected static $params = null;


    /**
     *  MapUl - Mapeia a url dividindo modules, controllers, actions e params
     *  @param array $param
     *  @return 
     */
	public static function MapUrl($param=null) {

        // identificação do modulo
        $if_mod = false;
        $is_module = (array_search($param[1],self::$modules)===false) ? false : true; // nem adianta usar cast
        self::$routes['module'] = ($is_module) ?  $param[1] : "default";

        // acertar as keys do array
        $url_clean = ($is_module) ? array_slice($param,1) : $param;
        $url_clean =  array_slice($url_clean, 0);

        (! $is_module) ? self::$routes['controller'] = ucfirst($url_clean[0]) : "";
        self::$routes['action'] = (isset($url_clean[1])) ? self::CamelCase($url_clean[1]) : self::$routes['action'];
        $param_url = array_slice($url_clean, 2); // divido controller+view de parametros
        $param_url = array_chunk($param_url, 2); // divido key + chave para formar um array de parametros
        $param_url = array_map(array('library_renderize', 'Treat_Params'),$param_url);
        self::$routes['params'] = $param_url;

        self::CheckRoutes(self::$routes,$url_clean,$is_module);

    }

    public static function CheckRoutes($routes=null,$url_clean=null,$is_module=false) {
        $fileController = APP_PATH . 'modules/' . self::$routes['module'] .'/controllers/'; 
        $fileController .= (! $is_module) ? self::CamelCase($url_clean[0]) : self::$routes['controller'];
        $fileController .= '.php'; 

        if (! file_exists($fileController)) {
            self::$routes['controller'] = "Index";
            $className = self::$routes['module'] .'_controllers_Index';
        } else {
            self::$routes['controller'] = (!$is_module) ? $url_clean[0] : self::$routes['controller'];
            return;
        }

        $objIndiretoController =  $className::singleton($className); // singleton   
        $action = ucfirst($url_clean[0]);
        $chekMethod = method_exists($objIndiretoController, $action);                

        if ($chekMethod) {
            self::$routes['action'] = self::CamelCase($url_clean[0]);
        } else {
            self::$routes['action'] = 'Error';
        }

    }



    /**
     * 	Treat_Params - Trata os parametros passados pela url
     *	@param array $param
     *  @todo função de callback
     *	@return string $rest // array('chave'=>'valor')
     */
    public static function Treat_Params($params=null) {
         $key = $params[0];
         $value = $params[1];
         $rest[$key] = $value;
         return $rest;
    }

    
}