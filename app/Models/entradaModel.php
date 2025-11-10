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
        $sql = "SELECT e.*, GROUP_CONCAT(DISTINCT f.nombre SEPARATOR ', ') as fraternidades,
                       GROUP_CONCAT(DISTINCT c.hora SEPARATOR ', ') as horarios
                FROM ".$this->nombreTabla." e 
                LEFT JOIN ".$this->tablaCronograma." c ON e.id_entrada = c.id_entrada 
                LEFT JOIN fraternidad f ON c.id_fraternidad = f.id_fraternidad
                GROUP BY e.id_entrada";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getEntradaById($id){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->nombreTabla." WHERE id_entrada = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getCronogramaByEntrada($id_entrada){
        $this->getConection();
        $sql = "SELECT c.*, f.nombre as fraternidad 
                FROM ".$this->tablaCronograma." c 
                LEFT JOIN fraternidad f ON c.id_fraternidad = f.id_fraternidad 
                WHERE c.id_entrada = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id_entrada]);
        return $stmt->fetchAll();
    }
    
    public function createEntrada($data){
        $this->getConection();
        $sql = "INSERT INTO ".$this->nombreTabla." (nombre, gestion, fecha) VALUES (?, ?, ?)";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$data['nombre'], $data['gestion'], $data['fecha']]);
        return $this->conection->lastInsertId();
    }
    
    public function updateEntrada($id, $data){
        $this->getConection();
        $sql = "UPDATE ".$this->nombreTabla." SET nombre = ?, gestion = ?, fecha = ? WHERE id_entrada = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$data['nombre'], $data['gestion'], $data['fecha'], $id]);
    }
    
    public function deleteEntrada($id){
        $this->getConection();
        // Primero eliminar registros relacionados en cronograma
        $sqlDeleteCronograma = "DELETE FROM ".$this->tablaCronograma." WHERE id_entrada = ?";
        $stmt1 = $this->conection->prepare($sqlDeleteCronograma);
        $stmt1->execute([$id]);
        
        // Luego eliminar la entrada
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
    
    public function eliminarCronograma($id_entrada, $id_fraternidad){
        $this->getConection();
        $sql = "DELETE FROM ".$this->tablaCronograma." WHERE id_entrada = ? AND id_fraternidad = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$id_entrada, $id_fraternidad]);
    }
}
?>