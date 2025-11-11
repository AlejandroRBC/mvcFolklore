<?php
require_once('app/Models/puntuacionModel.php');
require_once('app/Models/fraternidadModel.php');
require_once('app/Models/usuarioModel.php');

class puntuacionController{
    public $view;
    public $tituloVista;
    public $puntuacionObj;
    public $fraternidadObj;
    public $usuarioObj;
    
    public function __construct(){
        $this->puntuacionObj = new puntuacionModel();
        $this->fraternidadObj = new fraternidadModel();
        $this->usuarioObj = new usuarioModel();
    }
    
    public function puntuar(){
        session_start();
        if(!isset($_SESSION['logged_in'])){
            header("Location: index.php?controller=authController&funcion=login");
            exit();
        }
        
        $this->tituloVista = 'Puntuar Fraternidad';
        $this->view = "puntuaciones/puntuarForm";
        
        $id_fraternidad = $_GET['id'] ?? null;
        $id_usuario = $_SESSION['usuario_id'];
        
        if(!$id_fraternidad){
            return ['error' => 'Fraternidad no especificada'];
        }
        
        $fraternidad = $this->fraternidadObj->getFraternidadById($id_fraternidad);
        if(!$fraternidad){
            return ['error' => 'Fraternidad no encontrada'];
        }
        
        // Verificar si el usuario ya puntuó esta fraternidad
        $puntuacionExistente = $this->usuarioObj->getPuntuacionUsuario($id_usuario, $id_fraternidad);
        
        if($_POST){
            $puntuacion = $_POST['puntuacion'] ?? 0;
            $comentario = $_POST['comentario'] ?? '';
            
            if($puntuacion >= 1 && $puntuacion <= 5){
                if($this->puntuacionObj->agregarPuntuacion($id_fraternidad, $id_usuario, $puntuacion, $comentario)){
                    header("Location: index.php?controller=fraternidadController&funcion=detalle&id=" . $id_fraternidad);
                    exit();
                } else {
                    return ['error' => 'Error al guardar la puntuación'];
                }
            } else {
                return ['error' => 'La puntuación debe ser entre 1 y 5'];
            }
        }
        
        return [
            'fraternidad' => $fraternidad,
            'puntuacion_existente' => $puntuacionExistente,
            'promedio' => $this->puntuacionObj->getPromedioFraternidad($id_fraternidad)
        ];
    }
    
    public function ranking(){
        $this->tituloVista = 'Fraternidades Mejor Puntuadas';
        $this->view = "puntuaciones/ranking";
        
        return [
            'fraternidades' => $this->puntuacionObj->getFraternidadesMejorPuntuadas(20)
        ];
    }
    
    public function verPuntuaciones(){
        $this->tituloVista = 'Puntuaciones de la Fraternidad';
        $this->view = "puntuaciones/verPuntuaciones";
        
        $id_fraternidad = $_GET['id'] ?? null;
        
        if(!$id_fraternidad){
            return ['error' => 'Fraternidad no especificada'];
        }
        
        $fraternidad = $this->fraternidadObj->getFraternidadById($id_fraternidad);
        
        return [
            'fraternidad' => $fraternidad,
            'puntuaciones' => $this->puntuacionObj->getPuntuacionesFraternidad($id_fraternidad),
            'promedio' => $this->puntuacionObj->getPromedioFraternidad($id_fraternidad)
        ];
    }
    
}
?>