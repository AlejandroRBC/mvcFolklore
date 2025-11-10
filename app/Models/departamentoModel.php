<?php
class departamentoModel{
    private $nombreTabla = 'departamento';
    private $tablaEsDe = 'es_de';
    private $conection;

    public function __construct(){}
    
    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }
    
    public function getAllDepartamentos(){
        $this->getConection();
        $sql = "SELECT d.*, 
                       COUNT(ed.id_baile) as total_bailes,
                       GROUP_CONCAT(DISTINCT b.nombre SEPARATOR ', ') as bailes
                FROM ".$this->nombreTabla." d 
                LEFT JOIN ".$this->tablaEsDe." ed ON d.id_departamento = ed.id_departamento
                LEFT JOIN baile b ON ed.id_baile = b.id_baile
                GROUP BY d.id_departamento
                ORDER BY d.nombre";
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
    
    public function getBailesByDepartamento($id_departamento){
        $this->getConection();
        $sql = "SELECT b.* FROM baile b 
                INNER JOIN ".$this->tablaEsDe." ed ON b.id_baile = ed.id_baile 
                WHERE ed.id_departamento = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id_departamento]);
        return $stmt->fetchAll();
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
        
        // Primero eliminar registros relacionados en la tabla es_de
        $sqlDeleteEsDe = "DELETE FROM ".$this->tablaEsDe." WHERE id_departamento = ?";
        $stmt1 = $this->conection->prepare($sqlDeleteEsDe);
        $stmt1->execute([$id]);
        
        // Luego eliminar el departamento
        $sql = "DELETE FROM ".$this->nombreTabla." WHERE id_departamento = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function asignarBaile($id_departamento, $id_baile){
        $this->getConection();
        // Verificar si ya existe la relación
        $sqlCheck = "SELECT COUNT(*) FROM ".$this->tablaEsDe." WHERE id_departamento = ? AND id_baile = ?";
        $stmtCheck = $this->conection->prepare($sqlCheck);
        $stmtCheck->execute([$id_departamento, $id_baile]);
        $exists = $stmtCheck->fetchColumn();
        
        if($exists == 0) {
            $sql = "INSERT INTO ".$this->tablaEsDe." (id_departamento, id_baile) VALUES (?, ?)";
            $stmt = $this->conection->prepare($sql);
            return $stmt->execute([$id_departamento, $id_baile]);
        }
        return false;
    }
    
    public function eliminarBaile($id_departamento, $id_baile){
        $this->getConection();
        $sql = "DELETE FROM ".$this->tablaEsDe." WHERE id_departamento = ? AND id_baile = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id_departamento, $id_baile]);
    }
    
    public function getDepartamentosConEstadisticas(){
        $this->getConection();
        $sql = "SELECT d.*, 
                       COUNT(ed.id_baile) as total_bailes,
                       COUNT(DISTINCT f.id_fraternidad) as total_fraternidades
                FROM ".$this->nombreTabla." d 
                LEFT JOIN ".$this->tablaEsDe." ed ON d.id_departamento = ed.id_departamento
                LEFT JOIN baile b ON ed.id_baile = b.id_baile
                LEFT JOIN fraternidad f ON b.id_baile = f.id_baile
                GROUP BY d.id_departamento
                ORDER BY d.nombre";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>