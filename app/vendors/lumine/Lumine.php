<?php

/**
 * Classe principal
 *
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Lumine
 */
/**
 * Define o diretorio absolute de lumine
 * @var string
 */
define('LUMINE_INCLUDE_PATH', dirname(__FILE__));

/**
 * Classe principal
 *
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Lumine
 */
abstract class Lumine {
    const DEFAULT_VALUE_FUNCTION_IDENTIFIER = '_function:';

    /**
     * Plugins registrados
     * @var array
     */
    protected static $_plugins = array();

    /**
     * Carrega arquivos do pacote
     *
     * @author Hugo Ferreira da Silva
     * @return void
     */
    public static function load() {
        $args = func_get_args();
        foreach ($args as $libname) {
            if(strpos($libname, 'Lumine_') === 0){
                $basedir = LUMINE_INCLUDE_PATH . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;
                $libname = preg_replace('@^Lumine_@', '', $libname);
                $newfile = $basedir . str_replace('_', DIRECTORY_SEPARATOR, $libname) . '.php';

                require_once $newfile;
            }
        }
    }

    /**
     * Importa arquivos
     *
     * @author Hugo Ferreira da Silva
     * @return void
     */
    public static function import() {
        $args = func_get_args();
        $cn = Lumine_ConnectionManager::getInstance();
        $list = $cn->getConfigurationList();

        $cfg = array_shift($list);
        $pacote = $cfg->getProperty('package');

        if (!empty($pacote)) {
            $pacote .= '.';
        }

        foreach ($args as $classname) {
            Lumine_Util::Import($pacote . $classname);

            if ($cfg->getOption('auto_cast_dto')) {
                $name = sprintf($cfg->getOption('dto_format'), $classname);
                self::importDTO($name);
            }
        }
    }

    /**
     * Carrega models
     * 
     * @author Hugo Ferreira da Silva
     * @link http://www.hufersil.com.br
     * @return void
     */
    public static function loadModel() {
        $args = func_get_args();
        $cn = Lumine_ConnectionManager::getInstance();
        $list = $cn->getConfigurationList();

        $cfg = array_shift($list);
        $path = $cfg->getProperty('class_path')
                . DIRECTORY_SEPARATOR
                . $cfg->getOption('model_path')
                . DIRECTORY_SEPARATOR;

        foreach ($args as $classname) {
            $filename = $path . $classname . '.php';
            if (file_exists($filename)) {
                require_once $filename;
            }
        }
    }

    /**
     * Permite criar uma classe para uma tabela 
     * 
     * @author Hugo Ferreira da Silva
     * @link http://www.hufersil.com.br
     * @param string $tablename
     * @return Lumine_Factory
     */
    public static function factory($tablename) {
        $list = Lumine_ConnectionManager::getInstance()->getConfigurationList();
        $cfg = array_shift($list);

        return $cfg->factory($tablename);
    }

    /**
     * Importa o DTO relacionado a classe, quando houver
     * @author Hugo Ferreira da Silva
     * @link http://www.hufersil.com.br/
     * @return void
     */
    public static function importDTO() {
        $args = func_get_args();
        $cn = Lumine_ConnectionManager::getInstance();
        $list = $cn->getConfigurationList();

        $cfg = array_shift($list);


        /////////////////////////////////////////////////////////////
        // alteracoes para poder buscar os DTO's em varios pacotes
        /////////////////////////////////////////////////////////////
        $dtoPkgList = $cfg->getOption('dto_package');
        if (!is_array($dtoPkgList)) {
            $dtoPkgList = array($dtoPkgList);
            $cfg->setOption('dto_package', $dtoPkgList);
        }

        foreach ($dtoPkgList as $dtoPkg) {
            $path = $cfg->getProperty('class_path')
                    . DIRECTORY_SEPARATOR
                    . str_replace('.', DIRECTORY_SEPARATOR, $cfg->getProperty('package'))
                    . DIRECTORY_SEPARATOR
                    . 'dto'
                    . DIRECTORY_SEPARATOR
                    . str_replace('.', DIRECTORY_SEPARATOR, $dtoPkg)
                    . DIRECTORY_SEPARATOR;

            foreach ($args as $classname) {
                Lumine_Log::debug('procurando dto ' . $path . $classname);
                $filename = $path . $classname . $cfg->getOption('class_sufix') . '.php';

                if (file_exists($filename)) {
                    require_once $filename;
                }
            }
        }
    }

    /**
     * Checa se um valor e realmente nulo
     *
     * @param mixed $val Valor a ser comparado
     * @author Hugo Ferreira da Silva
     * @return boolean True se for nulo, do contratio false
     */
    public static function is_empty($val) {
        return gettype($val) == 'NULL';
    }

    /**
     * faz a importacao automatica de classes (autoload)
     *
     * @see http://br2.php.net/manual/pt_BR/function.spl-autoload-register.php
     * @param string $clname
     */
    public static function autoload($clname) {
        $args = func_get_args();
        $cn = Lumine_ConnectionManager::getInstance();
        $list = $cn->getConfigurationList();


        foreach ($list as $cfg) {
            $sufix = $cfg->getOption('class_sufix');
            $pacote = $cfg->getProperty('package');
            $path = $cfg->getProperty('class_path');

            $ext = (empty($sufix) ? '' : '.' . $sufix) . '.php';

            if (!empty($pacote)) {
                $pacote .= '.';
            }

            $fullpath = str_replace('.', '/', $path . '/' . $pacote . $clname);
            $fullpath .= $ext;

            if (file_exists($fullpath)) {
                Lumine_Util::import($pacote . $clname);
                return;
            }
        }
    }

    /**
     * Destroi o objeto
     * 
     * @author Hugo Ferreira da Silva
     * @link http://www.hufersil.com.br/
     * @param Lumine_Base $obj
     * @return void
     */
    public static function destroy(Lumine_Base &$obj) {
        $obj->destroy();
        unset($obj);
    }

    /**
     * Registra plugins para serem chamados no Lumine
     * 
     * @author Hugo Ferreira da silva
     * @link http://www.hufersil.com.br
     * @param ILumine_Plugin $class
     * @return unknown_type
     */
    public static function registerPlugin(ILumine_Plugin $class) {
        if (is_string($class)) {
            $ref = new ReflectionClass();
            $class = $ref->newInstance();
        }

        // vamos verificar se algum metodo existente na classe
        // conflita com algum ja registrado
        foreach ($class->getMethodList() as $methodName) {
            if (array_key_exists($methodName, self::$_plugins)) {
                throw new Lumine_Exception('O metodo "' . $methodName . '" ja esta registrado para outro plugin', -20);
            }
            // vamos indicar quais metodos este plugin usa
            self::$_plugins[$methodName] = $class;
        }
    }

    /**
     * Executa um plugin registrado
     * 
     * @param string      $method Nome do metodo
     * @param Lumine_Base $obj    Objeto de escopo para a chamada do plugin
     * @param array       $args   Argumentos
     * @author Hugo Ferreira da silva
     * @link http://www.hufersil.com.br
     * @return mixed O retorno do metodo do plugin
     */
    public static function runPlugin($method, Lumine_Base $obj, array $args) {
        // se nao existir
        if (!array_key_exists($method, self::$_plugins)) {
            // retorna false
            throw new Lumine_Exception('Metodo inexistente: ' . $method, Lumine_Exception::NO_SUCH_METHOD);
        }

        // coloca o objeto de lumine na primeira posicao de argumentos
        array_unshift($args, $obj);

        // executa o metodo e retorna o mesmo retorno do metodo
        return call_user_func_array(array(self::$_plugins[$method], $method), $args);
    }

}

// carrega principais dependencias
require_once (dirname(__FILE__)) . '/lib/Utils/Util.php';
spl_autoload_register(array('Lumine','load'));

//Lumine::load('Utils_Util', 'Utils_Crypt', 'Event', 'Events_SQLEvent', 'Events_FormatEvent', 'Events_IteratorEvent', 'Annotations_Annotations');
//Lumine::load('Exception', 'SQLException', 'EventListener', 'Metadata', 'Tokenizer', 'Parser', 'Exception', 'Configuration', 'ConnectionManager', 'Base', 'Validator', 'Union', 'Factory', 'Model', 'IPlugin');


