<?php
class bailarinModel{
    private $nombreTabla = 'bailarin';
    private $tablaPertenece = 'pertenece';
    private $conection;

    public function __construct(){}
    
    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }
    
    public function getAllBailarines(){
        $this->getConection();
        $sql = "SELECT b.*, f.nombre as fraternidad 
                FROM ".$this->nombreTabla." b 
                LEFT JOIN ".$this->tablaPertenece." p ON b.ci_bailarin = p.ci_bailarin 
                LEFT JOIN fraternidad f ON p.id_fraternidad = f.id_fraternidad";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getBailarinById($ci){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->nombreTabla." WHERE ci_bailarin = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$ci]);
        return $stmt->fetch();
    }
    
    public function createBailarin($data){
        $this->getConection();
        $sql = "INSERT INTO ".$this->nombreTabla." (ci_bailarin, nombre, fec_nac) VALUES (?, ?, ?)";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$data['ci_bailarin'], $data['nombre'], $data['fec_nac']]);
    }
    
    public function updateBailarin($ci, $data){
        $this->getConection();
        $sql = "UPDATE ".$this->nombreTabla." SET nombre = ?, fec_nac = ? WHERE ci_bailarin = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$data['nombre'], $data['fec_nac'], $ci]);
    }
    
    public function deleteBailarin($ci){
        $this->getConection();
        $sql = "DELETE FROM ".$this->nombreTabla." WHERE ci_bailarin = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$ci]);
    }
    
    public function asignarFraternidad($ci_bailarin, $id_fraternidad){
        $this->getConection();
        $sql = "INSERT INTO ".$this->tablaPertenece." (ci_bailarin, id_fraternidad) VALUES (?, ?)";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$ci_bailarin, $id_fraternidad]);
    }
}
?>