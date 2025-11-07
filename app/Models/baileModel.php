<?php
    class baileModel{
        // propiedades
        private $nombreTabla= 'baile';
        private $conection;

        public function __construct(){}
        public function getConection(){
            $dbObj = new Db();
            $this->conection = $dbObj->conection;
        }
        // funciones
        public function getBailes() :mixed {
            $this->getConection();
            $sql = "SELECT * FROM ".$this->nombreTabla;
            $stmt = $this->conection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

?>