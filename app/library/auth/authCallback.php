<?php

define('AUTH_CALLBACK', 'authCallback');

/**
 * Generates login forms and shows authentication messages to the user when needed.
 * This is where you can change the aspect of this forms. Also, if you want to log your
 * authentication trafic set $logging variable to true. and set the corresponding
 * variables according to http://www.php.net/error_log
 *
 * @version 2.4 pl3
 * @param $action		int, one of AUTH_NEED_LOGIN, AUTH_INVALID_USER, AUTH_EXPIRED,
 *                      AUTH_ACCESS_DENIED.
 * @param $message		string a message to show to the user.
 * @param $auth			object Auth.
 * @access public
 */
function authCallback($action, $message = '', &$auth=null) {
	if(!isset($_GET)) {
		$_COOKIE = &$GLOBALS['HTTP_COOKIE_VARS'];
		$_ENV = &$GLOBALS['HTTP_ENV_VARS'];
		$_GET = &$GLOBALS['HTTP_GET_VARS'];
		$_POST = &$GLOBALS['HTTP_POST_VARS'];
		$_SERVER = &$GLOBALS['HTTP_SERVER_VARS'];
		$_SESSION = &$GLOBALS['HTTP_SESSION_VARS'];
		$_REQUEST = array_merge($_GET, $_POST, $_COOKIE);
	}

	// Configuration.
	$logging = false;
	$logType = 0;
	$logDest = '';
	$logHeaders = '';

        
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Autentica&ccedil;&atilde;o</title>
    <style type="text/css">
/*<![CDATA[*/
body {
	background-color: #FFF;
	font-family: Verdana, Helvetica, sans-serif;
	font-size: 10pt;
}

div, li, p, td, th {
	font-family: Verdana, Helvetica, sans-serif;
	font-size: 10pt;
}

.content{
	background-color: #EEE;
	border: 1px solid #CCC;
	width: 450px;
}

.content .title {
	background: white;
	border: 1px solid #CCC;
	color: #369;
	font-size: 12pt;
	font-weight: bold;
	padding: 10px;
}

.content th {
	background-color: #BDE;
	border: 1px solid #ABD;
	font-size: 12pt;
	font-wight: bold;
}

.content td {
	text-align:center;
}

.content .text {
	background-color: #DDD;
	border: 1px inset #CCC;
	font-size: 8pt;
	width: 200px;
}

.content .button {
	background-color: #DDD;
	border: 1px outset #CCC;
	font-size:8pt;
	padding: 2px 4px 2px 4px;
}

/*]]>*/
    </style>
  </head>
  <body>

    <table align="center" class="content" cellspacing="10">
      <tr>
        <td class="title" colspan="2"><?php echo $message; ?></td>
      </tr>
<?php

global $Auth;

	switch($action) {
            case AUTH_NEED_LOGIN:
?>
    <!--<form action="<?php // echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">-->
    <form action="<?php echo APP_URL; ?>admin" method="post">
      <tr>
        <th>Username:</th>
        <td><input class="text" name="username<?php // echo $Auth->_options['usernameField']; ?>" type="text" maxlength="32"/></td>
      <tr>
        <th>Password:</th>
        <td><input class="text" name="password<?php // echo $Auth->_options['passwordField']; ?>" type="password"/></td>
      </tr>
      <tr>
        <td colspan="2">To access this zone you need to provide a valid username/password
        pair. If you lost your account info you can use our <a href="/lostpassword.php">
        reset password</a> form to access your account again.</td>
      </tr>
      <tr>
        <td colspan="2"><input class="button" type="submit" value="Login"/> <input class="button" onclick="history.go(-1);" type="button" value="Cancel"/></td>
      </tr>
    </form>
<?php
		break;

		case AUTH_INVALID_USER:
?>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <tr>
          <th>Username:</th>
          <td><input class="text" name="<?php echo $Auth->_options['usernameField']; ?>" type="text" maxlength="32" /></td>
        </tr>
        <tr>
          <th>Password:</th>
          <td><input class="text" name="<?php echo $Auth->_options['passwordField']; ?>" type="password" /></td>
        </tr>
        <tr>
          <td colspan="2">Your account doesn't exists. Please correct your information. If you lost your account info you can use our <a href="/lostpassword.php">reset password</a> form to access your account again.</td>
        </tr>
        <tr>
          <td colspan="2"><input class="button" type="submit" value="Login"/> <input class="button" onclick="history.go(-1);" type="button" value="Cancel"/></td>
        </tr>
      </form>
<?php
		break;

		case AUTH_EXPIRED:
?>
      <tr>
        <td colspan="2">Your session just expired. Please login again.</td>
      </tr>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <tr>
          <th>Username:</th>
          <td><input class="text" name="<?php echo $Auth->_options['usernameField']; ?>"
          type="text" maxlength="32" /></td>
        </tr>
        <tr>
          <th>Password:</th>
          <td><input class="text" name="<?php echo $Auth->_options['passwordField']; ?>"
          type="password" /></td>
        </tr>
        <tr>
          <td colspan="2">To access this zone you need to provide a valid
          username/password pair. If you lost your account info you can use our <a
          href="/lostpassword.php">reset password</a> form to access your account
          again.</td>
        </tr>
        <tr>
          <td colspan="2"><input class="button" type="submit" value="Login"/> <input
          class="button" onclick="history.go(-1);" type="button" value="Cancel"/></td>
        </tr>
      </form>
<?php
		break;

		case AUTH_ACCESS_DENIED:
		default:
?>
      <tr>
        <td>Your don't have access to this zone. Please leave it now!.</td>
      </tr>
      <tr>
        <td><input class="button" onclick="history.go(-1);" type="button" value="Exit"/></td>
      </tr>
<?php
		break;
	}
?>
    </table>
  </body>
</html>
<?php

	if($logging) {
		error_log("AUTH MESSAGE: $message", logType, $logDest,
			$logHeaders);
	}
	die();
}

?>
