<?php
class fraternidadModel{
    private $nombreTabla = 'fraternidad';
    private $conection;

    public function __construct(){}
    
    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }
    
    public function getAllFraternidades(){
        $this->getConection();
        $sql = "SELECT f.*, b.nombre as nombre_baile 
                FROM ".$this->nombreTabla." f 
                LEFT JOIN baile b ON f.id_baile = b.id_baile";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getFraternidadById($id){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->nombreTabla." WHERE id_fraternidad = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function createFraternidad($data){
        $this->getConection();
        $sql = "INSERT INTO ".$this->nombreTabla." (nombre, fecha_creacion, id_baile) VALUES (?, ?, ?)";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$data['nombre'], $data['fecha_creacion'], $data['id_baile']]);
    }
    
    public function updateFraternidad($id, $data){
        $this->getConection();
        $sql = "UPDATE ".$this->nombreTabla." SET nombre = ?, fecha_creacion = ?, id_baile = ? WHERE id_fraternidad = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$data['nombre'], $data['fecha_creacion'], $data['id_baile'], $id]);
    }
    
    public function deleteFraternidad($id){
        $this->getConection();
        $sql = "DELETE FROM ".$this->nombreTabla." WHERE id_fraternidad = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>