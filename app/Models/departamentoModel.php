<?php
class departamentoModel{
    private $nombreTabla = 'departamento';
    private $conection;

    public function __construct(){}
    
    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }
    
    public function getAllDepartamentos(){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->nombreTabla;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getDepartamentoById($id){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->nombreTabla." WHERE id_departamento = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function createDepartamento($data){
        $this->getConection();
        $sql = "INSERT INTO ".$this->nombreTabla." (nombre, region) VALUES (?, ?)";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$data['nombre'], $data['region']]);
    }
    
    public function updateDepartamento($id, $data){
        $this->getConection();
        $sql = "UPDATE ".$this->nombreTabla." SET nombre = ?, region = ? WHERE id_departamento = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$data['nombre'], $data['region'], $id]);
    }
    
    public function deleteDepartamento($id){
        $this->getConection();
        $sql = "DELETE FROM ".$this->nombreTabla." WHERE id_departamento = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>