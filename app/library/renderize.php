<?php
/**
 * Class Rendirize
 * @package 
 * @author Kaio Cesar <tecnico.kaio@gmail.com>
 * @version 1.0
 */

class library_renderize extends library_filterUrl{
    
    private static $instance;

    private function __construct() {}

    public static function singleton() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    
    /**
     * Run - Executa a renderização da aplicação
     * @todo
     */
    public static function Run() {
        // 1 - definimos modules, controllers, actions e params
        // PHP é lindo *-*   
        @ $redirect_url = preg_split('[\\/]', $_SERVER['REDIRECT_URL'], -1, PREG_SPLIT_NO_EMPTY);
        
        self::MapUrl($redirect_url);

        // 2 - checar a existencia dos arquivos de acordo com as rotas
        $classController = self::$routes['module'] ."_controllers_". self::$routes['controller'];
        
        $objController =  $classController::singleton($classController); // singleton

        $action = self::$routes['action'];

        $objController->$action();

    }

}