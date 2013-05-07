<?php 
 /**
  *	Users - Controller
  *	@author Kaio Cesar <tecnico.kaio@gmail.com>
  */

 class admin_controllers_users extends library_Controller {

	public function Home() {
		return self::Make('index.home');
	}


 }