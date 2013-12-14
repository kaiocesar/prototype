<?php
/**
 * Configurações de inicialização da aplicação
 * @package MFK
 * @author Kaio Cesar <tecnico.kaio@gmail.com>
 * @version 1.0
 */


/**
 *  Definition of environment
 */
if(preg_match("/192\.168\.[0-9]{1,3}\.[0-9]{1,3}/", $_SERVER['SERVER_ADDR']) || $_SERVER['SERVER_ADDR'] == "127.0.0.1"){ 
    define('ENV_APP', 1);
} else {
    define('ENV_APP', 0);
}



/**
 * Definition of the constants
 */
if (ENV_APP) {
    /**
    *  Development
    */
    define("APP_PATH", dirname(dirname(__FILE__)) . '/');
    define('APP_URL', 'http://'.$_SERVER['HTTP_HOST']);
    define('MODULES_PATH',APP_PATH . 'modules/');
    error_reporting(E_ALL);

} else {
    /**
    * Production
    */
    define("APP_PATH", "home/path-to-server/");
    define('APP_URL', 'http://yourdomain.com/');
    define('MODULES_PATH',APP_PATH . 'modules/');
    error_reporting(0);
}



/**
* Variables
*/
    define('DB_NEED', false);
    define('APP_TITLE', 'PROTOTIPO');
    $content_layout = null;

/**
* Includes
*/
    include(APP_PATH.'configs/database.php');
    include(APP_PATH.'library/autoloader.php');
    include(APP_PATH.'configs/routes.php');
    
    include(APP_PATH.'vendors/lumine/Lumine.php');
    include(APP_PATH.'vendors/lumine/lumine-conf.php');


    Lumine_Log::setLevel( 3 ); // Debug
    date_default_timezone_set("America/Sao_Paulo");

    $cfg = new Lumine_Configuration($lumineConfig);

    spl_autoload_register(function($class) {
            Lumine::autoload($class);
    });







    // $auth = library_auth2_auth::singleton();

    // $auth::checkAuthentication();

    // exit;
