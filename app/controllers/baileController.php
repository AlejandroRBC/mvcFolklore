<?php
require_once('app/Models/baileModel.php');
class baileController{
    public $view = "bailes/baileView";
    public $tituloVista;
    public $baileObj;
    
    public function __construct(){
        $this->baileObj = new baileModel();
    }
    public function listar(){
        $this->tituloVista = 'Listado de Bailes';
        return $this->baileObj->getBailes();
    }
}
?>