<?php
/**
 * Auto loader
 * @author Kaio Cesar <tenico.kaio@gmail.com>
 * @package MFK
 * @version 1.0
 */


// function __autoload($class=null) {
//     $class_inc = str_replace("_", "/", $class);
//     $class_exp = explode('_', $class);
//     if ($class_exp[0] == 'default' || $class_exp[0] == 'admin') {
//         include MODULES_PATH . $class_inc . ".php";
//     } else {
//         include APP_PATH . $class_inc . ".php";
//     }
// }




spl_autoload_register(function ($class) {

   if (strpos($class, 'Lumine')===0) {
   		return false;  // é ridiculo, mas um dia melhora
   }

   $class_inc = str_replace("_", "/", $class);
   
   $class_exp = explode('_', $class);
   
   if ($class_exp[0] == 'default' || $class_exp[0] == 'admin') {
       include MODULES_PATH . $class_inc . ".php";
   } else {
       include APP_PATH . $class_inc . ".php";
   }

});

