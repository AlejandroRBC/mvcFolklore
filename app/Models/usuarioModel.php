<?php
class usuarioModel{
    private $nombreTabla = 'usuario';
    private $tablaPuntua = 'puntua';
    private $conection;

    public function __construct(){}
    
    public function getConection(){
        $dbObj = new Db();
        $this->conection = $dbObj->conection;
    }
    
    public function getUserByUsername($username){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->nombreTabla." WHERE username = ? AND activo = 1";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
    
    public function getUserById($id){
        $this->getConection();
        $sql = "SELECT id_usuario, username, email, nombre, apellido, fecha_registro, es_admin 
                FROM ".$this->nombreTabla." 
                WHERE id_usuario = ? AND activo = 1";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function createUser($data){
        $this->getConection();
        $sql = "INSERT INTO ".$this->nombreTabla." (username, email, password, nombre, apellido) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conection->prepare($sql);
        
        // Hash de la contraseña
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        return $stmt->execute([
            $data['username'], 
            $data['email'], 
            $hashedPassword, 
            $data['nombre'], 
            $data['apellido']
        ]);
    }
    
    public function verifyPassword($inputPassword, $hashedPassword){
        return password_verify($inputPassword, $hashedPassword);
    }
    
    public function getUserPuntuaciones($id_usuario){
        $this->getConection();
        $sql = "SELECT p.*, f.nombre as fraternidad_nombre, b.nombre as baile_nombre
                FROM ".$this->tablaPuntua." p
                INNER JOIN fraternidad f ON p.id_fraternidad = f.id_fraternidad
                LEFT JOIN baile b ON f.id_baile = b.id_baile
                WHERE p.id_usuario = ?
                ORDER BY p.fecha_puntuacion DESC";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll();
    }
    
    public function userHasPuntuadoFraternidad($id_usuario, $id_fraternidad){
        $this->getConection();
        $sql = "SELECT COUNT(*) FROM ".$this->tablaPuntua." 
                WHERE id_usuario = ? AND id_fraternidad = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id_usuario, $id_fraternidad]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function getPuntuacionUsuario($id_usuario, $id_fraternidad){
        $this->getConection();
        $sql = "SELECT * FROM ".$this->tablaPuntua." 
                WHERE id_usuario = ? AND id_fraternidad = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id_usuario, $id_fraternidad]);
        return $stmt->fetch();
    }
}
?>