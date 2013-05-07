<?php
/**
 * @author Kaio Cesar <tecnico.kaio@gmail.com>
 * @package MKF
 * @version 1.0
 */

include('../app/configs/app_init.php');

$render_app = library_renderize::singleton();

$render_app::Run(); 

