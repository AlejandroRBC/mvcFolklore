<?php
require_once('app/Models/fraternidadModel.php');
require_once('app/Models/baileModel.php');

class fraternidadController{
    public $view = "fraternidades/fraternidadView";
    public $tituloVista;
    public $fraternidadObj;
    public $baileObj;
    
    public function __construct(){
        $this->fraternidadObj = new fraternidadModel();
        $this->baileObj = new baileModel();
    }
    
    public function listar(){
        $this->tituloVista = 'Listado de Fraternidades';
        return [
            'fraternidades' => $this->fraternidadObj->getAllFraternidades(),
            'bailes' => $this->baileObj->getAllBailes()
        ];
    }
    
    public function crear(){
        $this->tituloVista = 'Crear Fraternidad';
        $this->view = "fraternidades/fraternidadForm";
        
        if($_POST){
            $data = [
                'nombre' => $_POST['nombre'],
                'fecha_creacion' => $_POST['fecha_creacion'],
                'id_baile' => $_POST['id_baile']
            ];
            
            if($this->fraternidadObj->createFraternidad($data)){
                header("Location: index.php?controller=fraternidadController&funcion=listar");
            }
        }
        
        return ['bailes' => $this->baileObj->getAllBailes()];
    }
    
    public function editar(){
        $this->tituloVista = 'Editar Fraternidad';
        $this->view = "fraternidades/fraternidadForm";
        
        $id = $_GET['id'] ?? null;
        
        if($_POST && $id){
            $data = [
                'nombre' => $_POST['nombre'],
                'fecha_creacion' => $_POST['fecha_creacion'],
                'id_baile' => $_POST['id_baile']
            ];
            
            if($this->fraternidadObj->updateFraternidad($id, $data)){
                header("Location: index.php?controller=fraternidadController&funcion=listar");
            }
        }
        
        return [
            'fraternidad' => $this->fraternidadObj->getFraternidadById($id),
            'bailes' => $this->baileObj->getAllBailes()
        ];
    }
    
    public function eliminar(){
        $id = $_GET['id'] ?? null;
        if($id && $this->fraternidadObj->deleteFraternidad($id)){
            header("Location: index.php?controller=fraternidadController&funcion=listar");
        }
        return [];
    }
}
?>