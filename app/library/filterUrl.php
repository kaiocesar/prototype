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

    protected static $keys = array(
        'module',
        'controller',
        'action',
        'params'
    );
    
	/**
	 * @var array $modules
	 */
	protected static $modules = array('default','admin');
    
    /**
     * @var Params
     */
    protected static $params = null;


    public static function SetKeysArray(){

    }


    /**
     *  MapUl - Mapeia a url dividindo modules, controllers, actions e params
     *  @param array $param
     *  @return 
     */
	public static function MapUrl($param=null) {

        // Não existe Rota ? então ele retornará as defaults
        if ((empty($param)) || (! is_array($param)) ) { return; }

        $rota = self::$routes;

        // module exists
        $is_module = (array_search($param[0],self::$modules)===false) ? false : true; // nem adianta usar cast

        $is = ($is_module) ? 1 : 0;
        
        $module = ($is_module) ? $param[0] : null;  // module

        if (($is_module && isset($param[1])))   // controller
            $controller = ucfirst($param[1]);
        else if(! $is_module && isset($param[0]))
            $controller = ucfirst($param[0]);
        else 
            $controller = null;
        
        
        if (($is_module && isset($param[2]))) // action
            $action = ucfirst($param[2]);
        else if (!$is_module && isset($param[0]) && isset($param[1]))
            $action = ucfirst($param[1]);
        else
            $action = null;

        
        (! is_null($module)) ? $rota['module'] = $module : "";
        (! is_null($controller)) ? $rota['controller'] = $controller : "";
        (! is_null($action)) ? $rota['action'] = $action : "";
        

        self::$routes = array_merge(self::$routes, $rota);

        $begin_cut_params = ($is_module) ? 3 : 2;

        $param_url = array_slice($param, $begin_cut_params); // divido controller+view de parametros    
        $param_url = array_chunk($param_url, 2); // divido key + chave para formar um array de parametros
        $param_url = array_map(array('library_renderize', 'Treat_Params'),$param_url);
        self::$routes['params'] = $param_url;


        self::CheckRoutes(self::$routes,$param,$is_module);

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