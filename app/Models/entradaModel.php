<?php
class entradaModel{
    private $nombreTabla = 'entrada';
    private $tablaCronograma = 'cronograma';
    private $conection;

    public function __construct(){}
    
    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }
    
    public function getAllEntradas(){
        $this->getConection();
        $sql = "SELECT e.*, c.hora, f.nombre as fraternidad 
                FROM ".$this->nombreTabla." e 
                LEFT JOIN ".$this->tablaCronograma." c ON e.id_entrada = c.id_entrada 
                LEFT JOIN fraternidad f ON c.id_fraternidad = f.id_fraternidad";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function createEntrada($data){
        $this->getConection();
        $sql = "INSERT INTO ".$this->nombreTabla." (nombre, gestion, fecha) VALUES (?, ?, ?)";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$data['nombre'], $data['gestion'], $data['fecha']]);
        return $this->conection->lastInsertId();
    }
    
    public function deleteEntrada($id){
        $this->getConection();
        $sql = "DELETE FROM ".$this->nombreTabla." WHERE id_entrada = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function asignarCronograma($id_entrada, $id_fraternidad, $hora){
        $this->getConection();
        $sql = "INSERT INTO ".$this->tablaCronograma." (id_entrada, id_fraternidad, hora) VALUES (?, ?, ?)";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id_entrada, $id_fraternidad, $hora]);
    }
}
?>