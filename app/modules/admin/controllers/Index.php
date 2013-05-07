<?php 
/**
 *  Index - Controller admin
 *	@author Kaio Cesar <tecnico.kaio@gmail.com>
 */

class admin_controllers_index extends library_Controller {


	public function Index() {
		return self::Make('index.home');
	}


}
