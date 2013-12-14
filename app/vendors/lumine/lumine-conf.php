<?php
#### START AUTOCODE
################################################################################
#  Lumine - Database Mapping for PHP
#  Copyright (C) 2005  Hugo Ferreira da Silva
#  
#  This program is free software: you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation, either version 3 of the License, or
#  (at your option) any later version.
#  
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#  
#  You should have received a copy of the GNU General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>
################################################################################
/**
 * Created by Lumine_Reverse
 * in 2013-12-14
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 *
 * Arquivo de configuração para "prototype_db"
 */

$lumineConfig = array(
    'dialect' => 'MySQL', 
    'database' => 'prototype_db', 
    'user' => 'root', 
    'password' => '37876732', 
    'port' => '3306', 
    'host' => '127.0.0.1', 
    'class_path' => '/opt/lampp/htdocs/prototype/app/vendors/lumine', 
    'package' => 'models', 
    'addons_path' => '', 
    'acao' => 'gerar', 

	
    'options' => array(
        'configID' => 'ci', 
        'tipo_geracao' => '1', 
        'classMapping' => 'annotations', 
        'cache' => 'APC', 
        'remove_prefix' => '', 
        'remove_count_chars_start' => '0', 
        'remove_count_chars_end' => '0', 
        'format_classname' => '', 
        'schema_name' => '', 
        'many_to_many_style' => '%s_%s', 
        'plural' => '', 
        'create_controls' => 'White', 
        'class_sufix' => '', 
        'keep_foreign_column_name' => '1', 
        'camel_case' => '1', 
        'usar_dicionario' => '1', 
        'create_paths' => '1', 
        'dto_format' => '%sDTO', 
        'dto_package' => array(
            '0' => 'models',
        ), 
        'create_models' => '1', 
        'model_path' => 'system/application/models', 
        'model_format' => '%sModel', 
        'model_context' => '1', 
        'model_context_path' => 'system/application/libraries', 
        'classDescriptor' => 'annotations', 
        'overwrite' => '0', 
        'create_dtos' => '', 
        'generateAccessors' => '', 
        'create_entities_for_many_to_many' => '', 
        'generate_files' => '1', 
        'generate_zip' => '0'
    )
);



?>