<?php
/**
 * IndexController - Controller
 * @package 
 * @author kaio Cesar <tecnico.kaio@gmail.com>
 * @version 1.0
 */


class default_controllers_Index extends library_Controller {
    
    protected static $SayHello = '';

    public function Index () {
        self::$params = array('title_page'=>'Bem vindo ao Prototipo', 'title_content' => 'Esse é o prototipo de framework');

        return $this->Make('index.index');
    }
    
    public function Localizacao () {
        $this->title_page = "Nossa Localização";
        return $this->Make('index.localizacao');
    }
    
    public function Contato () {
        $this->title_page = "Fale Conosco";
        return $this->Make('index.contato');
    }
    
    public function InscrevaSe () {
        $this->title_page = "777 Agora Inscreva-se";
    }
      
    
}