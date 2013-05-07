<?php
/**
 * IndexController - Controller
 * @path /app/modules/default/controller/
 * @author kaio Cesar <tecnico.kaio@gmail.com>
 * @version 3.0
 */

class default_controllers_Mural {
    
    public $title_page = null;
    
    public function Index () {
        $this->title_page = "Todos as fotos do mural";
    }
    
    public function Localizacao () {
        $this->title_page = "Nossa Localização";
    }
    
    public function Contato () {
        $this->title_page = "Fale Conosco";
    }
    
    public function InscrevaSe () {
        $this->title_page = "Inscreva-se";
    }
    
    
}