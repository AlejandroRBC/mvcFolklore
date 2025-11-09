<?php
class baileModel{
    private $nombreTabla = 'baile';
    private $tablaEsDe = 'es_de';
    private $conection;

    public function __construct(){}
    
    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }
    
    public function getAllBailes(){
        $this->getConection();
        $sql = "SELECT b.*, d.nombre as departamento 
                FROM ".$this->nombreTabla." b 
                LEFT JOIN ".$this->tablaEsDe." ed ON b.id_baile = ed.id_baile 
                LEFT JOIN departamento d ON ed.id_departamento = d.id_departamento";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getBaileById($id){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->nombreTabla." WHERE id_baile = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function createBaile($data){
        $this->getConection();
        $sql = "INSERT INTO ".$this->nombreTabla." (nombre, ritmo) VALUES (?, ?)";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$data['nombre'], $data['ritmo']]);
        return $this->conection->lastInsertId();
    }
    
    public function updateBaile($id, $data){
        $this->getConection();
        $sql = "UPDATE ".$this->nombreTabla." SET nombre = ?, ritmo = ? WHERE id_baile = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$data['nombre'], $data['ritmo'], $id]);
    }
    
    public function deleteBaile($id){
        $this->getConection();
        $sql = "DELETE FROM ".$this->nombreTabla." WHERE id_baile = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function asignarDepartamento($id_baile, $id_departamento){
        $this->getConection();
        $sql = "INSERT INTO ".$this->tablaEsDe." (id_baile, id_departamento) VALUES (?, ?)";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id_baile, $id_departamento]);
    }
}
?>