<?php
class fraternidadModel{
    private $nombreTabla = 'fraternidad';
    private $tablaPertenece = 'pertenece';
    private $tablaCronograma = 'cronograma';
    private $conection;

    public function __construct(){}
    
    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }
    
    public function getAllFraternidades(){
        $this->getConection();
        $sql = "SELECT f.*, b.nombre as nombre_baile, 
                       COUNT(p.ci_bailarin) as total_bailarines,
                       GROUP_CONCAT(DISTINCT e.nombre SEPARATOR ', ') as entradas
                FROM ".$this->nombreTabla." f 
                LEFT JOIN baile b ON f.id_baile = b.id_baile
                LEFT JOIN ".$this->tablaPertenece." p ON f.id_fraternidad = p.id_fraternidad
                LEFT JOIN ".$this->tablaCronograma." c ON f.id_fraternidad = c.id_fraternidad
                LEFT JOIN entrada e ON c.id_entrada = e.id_entrada
                GROUP BY f.id_fraternidad";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getFraternidadById($id){
        $this->getConection();
        $sql = "SELECT f.*, b.nombre as nombre_baile 
                FROM ".$this->nombreTabla." f 
                LEFT JOIN baile b ON f.id_baile = b.id_baile 
                WHERE f.id_fraternidad = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getBailarinesByFraternidad($id_fraternidad){
        $this->getConection();
        $sql = "SELECT b.* FROM bailarin b 
                INNER JOIN ".$this->tablaPertenece." p ON b.ci_bailarin = p.ci_bailarin 
                WHERE p.id_fraternidad = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id_fraternidad]);
        return $stmt->fetchAll();
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
        
        // Primero eliminar registros relacionados
        $sqlDeletePertenece = "DELETE FROM ".$this->tablaPertenece." WHERE id_fraternidad = ?";
        $stmt1 = $this->conection->prepare($sqlDeletePertenece);
        $stmt1->execute([$id]);
        
        $sqlDeleteCronograma = "DELETE FROM ".$this->tablaCronograma." WHERE id_fraternidad = ?";
        $stmt2 = $this->conection->prepare($sqlDeleteCronograma);
        $stmt2->execute([$id]);
        
        // Luego eliminar la fraternidad
        $sql = "DELETE FROM ".$this->nombreTabla." WHERE id_fraternidad = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function asignarBailarin($id_fraternidad, $ci_bailarin){
        $this->getConection();
        $sql = "INSERT INTO ".$this->tablaPertenece." (id_fraternidad, ci_bailarin) VALUES (?, ?)";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id_fraternidad, $ci_bailarin]);
    }
    
    public function eliminarBailarin($id_fraternidad, $ci_bailarin){
        $this->getConection();
        $sql = "DELETE FROM ".$this->tablaPertenece." WHERE id_fraternidad = ? AND ci_bailarin = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id_fraternidad, $ci_bailarin]);
    }
    public function getFraternidadConPuntuaciones($id){
        $this->getConection();
        $sql = "SELECT f.*, 
                       b.nombre as nombre_baile,
                       AVG(p.puntuacion) as promedio_puntuacion,
                       COUNT(p.puntuacion) as total_puntuaciones
                FROM ".$this->nombreTabla." f 
                LEFT JOIN baile b ON f.id_baile = b.id_baile
                LEFT JOIN puntua p ON f.id_fraternidad = p.id_fraternidad
                WHERE f.id_fraternidad = ?
                GROUP BY f.id_fraternidad";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
?>