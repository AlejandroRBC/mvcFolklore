<?php
    require_once('Models/baileModel.php');
    class baileController{
        public $vista;
        public $tituloVista;
        public $baileObj;
        /* Listar todos los bailes */
        public function list(){
            $this->tituloVista = 'Listado de Bailes';
            return $this->baileObj->getBailes();
        }
    }
?>