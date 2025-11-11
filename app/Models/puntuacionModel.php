<?php
class puntuacionModel{
    private $nombreTabla = 'puntua';
    private $conection;

    public function __construct(){}
    
    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }
    
    public function agregarPuntuacion($id_fraternidad, $id_usuario, $puntuacion, $comentario = null){
        $this->getConection();
        
        // Verificar si ya existe una puntuación
        $sqlCheck = "SELECT COUNT(*) FROM ".$this->nombreTabla." 
                     WHERE id_fraternidad = ? AND id_usuario = ?";
        $stmtCheck = $this->conection->prepare($sqlCheck);
        $stmtCheck->execute([$id_fraternidad, $id_usuario]);
        $existe = $stmtCheck->fetchColumn();
        
        if($existe) {
            // Actualizar puntuación existente
            $sql = "UPDATE ".$this->nombreTabla." 
                    SET puntuacion = ?, comentario = ?, fecha_puntuacion = CURRENT_TIMESTAMP 
                    WHERE id_fraternidad = ? AND id_usuario = ?";
        } else {
            // Insertar nueva puntuación
            $sql = "INSERT INTO ".$this->nombreTabla." (id_fraternidad, id_usuario, puntuacion, comentario) 
                    VALUES (?, ?, ?, ?)";
        }
        
        $stmt = $this->conection->prepare($sql);
        if($existe) {
            return $stmt->execute([$puntuacion, $comentario, $id_fraternidad, $id_usuario]);
        } else {
            return $stmt->execute([$id_fraternidad, $id_usuario, $puntuacion, $comentario]);
        }
    }
    
    public function getPuntuacionesFraternidad($id_fraternidad){
        $this->getConection();
        $sql = "SELECT p.*, u.username, u.nombre, u.apellido
                FROM ".$this->nombreTabla." p
                INNER JOIN usuario u ON p.id_usuario = u.id_usuario
                WHERE p.id_fraternidad = ?
                ORDER BY p.fecha_puntuacion DESC";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id_fraternidad]);
        return $stmt->fetchAll();
    }
    
    public function getPromedioFraternidad($id_fraternidad){
        $this->getConection();
        $sql = "SELECT AVG(puntuacion) as promedio, COUNT(*) as total_puntuaciones
                FROM ".$this->nombreTabla." 
                WHERE id_fraternidad = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id_fraternidad]);
        return $stmt->fetch();
    }
    
    public function getFraternidadesMejorPuntuadas($limite = 10){
        $this->getConection();
        
        $sql = "SELECT f.*, 
                       AVG(p.puntuacion) as promedio_puntuacion,
                       COUNT(p.puntuacion) as total_puntuaciones,
                       b.nombre as baile_nombre
                FROM fraternidad f
                LEFT JOIN ".$this->nombreTabla." p ON f.id_fraternidad = p.id_fraternidad
                LEFT JOIN baile b ON f.id_baile = b.id_baile
                GROUP BY f.id_fraternidad
                HAVING promedio_puntuacion IS NOT NULL
                ORDER BY promedio_puntuacion DESC, total_puntuaciones DESC
                LIMIT ?";
        
        $stmt = $this->conection->prepare($sql);
        $stmt->bindValue(1, (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
}
?>