<?php
require_once('app/Models/departamentoModel.php');

class departamentoController{
    public $view = "departamentos/departamentoView";
    public $tituloVista;
    public $departamentoObj;
    
    public function __construct(){
        $this->departamentoObj = new departamentoModel();
    }
    
    public function listar(){
        $this->tituloVista = 'Listado de Departamentos';
        return $this->departamentoObj->getAllDepartamentos();
    }
    
    public function crear(){
        $this->tituloVista = 'Crear Departamento';
        $this->view = "departamentos/departamentoForm";
        
        if($_POST){
            $data = [
                'nombre' => $_POST['nombre'],
                'region' => $_POST['region']
            ];
            
            if($this->departamentoObj->createDepartamento($data)){
                header("Location: index.php?controller=departamentoController&funcion=listar");
            }
        }
        return [];
    }
    
    public function editar(){
        $this->tituloVista = 'Editar Departamento';
        $this->view = "departamentos/departamentoForm";
        
        $id = $_GET['id'] ?? null;
        
        if($_POST && $id){
            $data = [
                'nombre' => $_POST['nombre'],
                'region' => $_POST['region']
            ];
            
            if($this->departamentoObj->updateDepartamento($id, $data)){
                header("Location: index.php?controller=departamentoController&funcion=listar");
            }
        }
        
        return $this->departamentoObj->getDepartamentoById($id);
    }
    
    public function eliminar(){
        $id = $_GET['id'] ?? null;
        if($id && $this->departamentoObj->deleteDepartamento($id)){
            header("Location: index.php?controller=departamentoController&funcion=listar");
        }
        return [];
    }
}
?>