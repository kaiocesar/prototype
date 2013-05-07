 <?php 
 /**
  * @author Kaio Cesar <tecnico.kaio@gmail.com>
  *	@version 1.0
  */

if (ENV_APP) {
	/**
	 * Development
	 */
	  define('DB_USER','root');
    define('DB_PASS','root');
    define('DB_NAME','db_name');
    define('DB_SERVER','localhost');	
} else {
	/**
	 * Production
	 */
  	define('DB_USER','root');
    define('DB_PASS','root');
    define('DB_NAME','db_name');
    define('DB_SERVER','localhost');  
}

/**
 * Connection Database
 */
if(DB_NEED) {
  $connection = mysql_connect(DB_SERVER,DB_USER, DB_PASS);
  mysql_select_db(DB_NAME,$connection)  or (ENV_APP) ? die(mysql_error()) : "";  
}

