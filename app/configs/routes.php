<?php
/**
 * Rotas da aplicação - config
 * @package app/configs
 * @author Kaio Cesar <tecnico.kaio@gmail.com>
 * @version 1.0
 */

/**
 * The path layout module
 */
$ROUTES['default']['layout_path'] = APP_PATH . 'modules/default/layout/';
$ROUTES['admin']['layout_path'] = APP_PATH . 'modules/admin/layout/';


/**
 * The path module
 */
$ROUTES['default']['path'] = APP_PATH . 'modules/default/';
$ROUTES['default']['404'] = APP_PATH . 'modules/default/views/404.html';
$ROUTES['admin']['path'] = APP_PATH . 'modules/admin/';
$ROUTES['admin']['404'] = APP_PATH . 'modules/admin/views/404.html';


/**
 * The content pages
 * Foi um solução que encontrei, diante ao mal escopo entre include e function
 */


$ROUTES['content_layout'] = '';