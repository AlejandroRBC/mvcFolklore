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
        $sql = "SELECT b.*, 
                       GROUP_CONCAT(DISTINCT d.nombre SEPARATOR ', ') as departamentos,
                       COUNT(DISTINCT d.id_departamento) as total_departamentos,
                       COUNT(DISTINCT f.id_fraternidad) as total_fraternidades
                FROM ".$this->nombreTabla." b 
                LEFT JOIN ".$this->tablaEsDe." ed ON b.id_baile = ed.id_baile 
                LEFT JOIN departamento d ON ed.id_departamento = d.id_departamento
                LEFT JOIN fraternidad f ON b.id_baile = f.id_baile
                GROUP BY b.id_baile
                ORDER BY b.nombre";
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
    
    public function getDepartamentosByBaile($id_baile){
        $this->getConection();
        $sql = "SELECT d.* FROM departamento d 
                INNER JOIN ".$this->tablaEsDe." ed ON d.id_departamento = ed.id_departamento 
                WHERE ed.id_baile = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id_baile]);
        return $stmt->fetchAll();
    }
    
    public function getFraternidadesByBaile($id_baile){
        $this->getConection();
        $sql = "SELECT f.* FROM fraternidad f 
                WHERE f.id_baile = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id_baile]);
        return $stmt->fetchAll();
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
        
        // Primero eliminar registros relacionados en la tabla es_de
        $sqlDeleteEsDe = "DELETE FROM ".$this->tablaEsDe." WHERE id_baile = ?";
        $stmt1 = $this->conection->prepare($sqlDeleteEsDe);
        $stmt1->execute([$id]);
        
        // Luego eliminar el baile
        $sql = "DELETE FROM ".$this->nombreTabla." WHERE id_baile = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function asignarDepartamento($id_baile, $id_departamento){
        $this->getConection();
        // Verificar si ya existe la relación
        $sqlCheck = "SELECT COUNT(*) FROM ".$this->tablaEsDe." WHERE id_baile = ? AND id_departamento = ?";
        $stmtCheck = $this->conection->prepare($sqlCheck);
        $stmtCheck->execute([$id_baile, $id_departamento]);
        $exists = $stmtCheck->fetchColumn();
        
        if($exists == 0) {
            $sql = "INSERT INTO ".$this->tablaEsDe." (id_baile, id_departamento) VALUES (?, ?)";
            $stmt = $this->conection->prepare($sql);
            return $stmt->execute([$id_baile, $id_departamento]);
        }
        return false;
    }
    
    public function eliminarDepartamento($id_baile, $id_departamento){
        $this->getConection();
        $sql = "DELETE FROM ".$this->tablaEsDe." WHERE id_baile = ? AND id_departamento = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id_baile, $id_departamento]);
    }
    
    public function buscarBailes($termino){
        $this->getConection();
        $sql = "SELECT b.* FROM ".$this->nombreTabla." b 
                WHERE b.nombre LIKE ? OR b.ritmo LIKE ?
                ORDER BY b.nombre";
        $stmt = $this->conection->prepare($sql);
        $termino = "%" . $termino . "%";
        $stmt->execute([$termino, $termino]);
        return $stmt->fetchAll();
    }
}
?>