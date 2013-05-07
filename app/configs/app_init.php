<?php
/**
 * Configurações de inicialização da aplicação
 * @package MFK
 * @author Kaio Cesar <tecnico.kaio@gmail.com>
 * @version 1.0
 */

// var_dump($_SERVER); exit;


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
    define("APP_PATH", "C:/xampp/htdocs/miniframework_v1/app/");
    define('APP_URL', 'http://localhost:1080/miniframework_v1/public_html/');
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


    // $auth = library_auth2_auth::singleton();

    // $auth::checkAuthentication();

    // exit;
