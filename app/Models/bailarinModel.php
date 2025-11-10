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
        $sql = "SELECT b.*, 
                       GROUP_CONCAT(DISTINCT f.nombre SEPARATOR ', ') as fraternidades,
                       COUNT(DISTINCT f.id_fraternidad) as total_fraternidades
                FROM ".$this->nombreTabla." b 
                LEFT JOIN ".$this->tablaPertenece." p ON b.ci_bailarin = p.ci_bailarin 
                LEFT JOIN fraternidad f ON p.id_fraternidad = f.id_fraternidad
                GROUP BY b.ci_bailarin
                ORDER BY b.nombre";
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
    
    public function getFraternidadesByBailarin($ci_bailarin){
        $this->getConection();
        $sql = "SELECT f.* FROM fraternidad f 
                INNER JOIN ".$this->tablaPertenece." p ON f.id_fraternidad = p.id_fraternidad 
                WHERE p.ci_bailarin = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$ci_bailarin]);
        return $stmt->fetchAll();
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
        
        // Primero eliminar registros relacionados en la tabla pertenece
        $sqlDeletePertenece = "DELETE FROM ".$this->tablaPertenece." WHERE ci_bailarin = ?";
        $stmt1 = $this->conection->prepare($sqlDeletePertenece);
        $stmt1->execute([$ci]);
        
        // Luego eliminar el bailarín
        $sql = "DELETE FROM ".$this->nombreTabla." WHERE ci_bailarin = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$ci]);
    }
    
    public function asignarFraternidad($ci_bailarin, $id_fraternidad){
        $this->getConection();
        // Verificar si ya existe la relación
        $sqlCheck = "SELECT COUNT(*) FROM ".$this->tablaPertenece." WHERE ci_bailarin = ? AND id_fraternidad = ?";
        $stmtCheck = $this->conection->prepare($sqlCheck);
        $stmtCheck->execute([$ci_bailarin, $id_fraternidad]);
        $exists = $stmtCheck->fetchColumn();
        
        if($exists == 0) {
            $sql = "INSERT INTO ".$this->tablaPertenece." (ci_bailarin, id_fraternidad) VALUES (?, ?)";
            $stmt = $this->conection->prepare($sql);
            return $stmt->execute([$ci_bailarin, $id_fraternidad]);
        }
        return false;
    }
    
    public function eliminarFraternidad($ci_bailarin, $id_fraternidad){
        $this->getConection();
        $sql = "DELETE FROM ".$this->tablaPertenece." WHERE ci_bailarin = ? AND id_fraternidad = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$ci_bailarin, $id_fraternidad]);
    }
    
    public function calcularEdad($fecha_nacimiento){
        if(empty($fecha_nacimiento)) return null;
        
        $nacimiento = new DateTime($fecha_nacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($nacimiento);
        return $edad->y;
    }
}
?>