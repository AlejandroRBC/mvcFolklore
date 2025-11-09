<?php
require_once('app/Models/baileModel.php');
require_once('app/Models/departamentoModel.php');

class baileController{
    public $view = "bailes/baileView";
    public $tituloVista;
    public $baileObj;
    public $departamentoObj;
    
    public function __construct(){
        $this->baileObj = new baileModel();
        $this->departamentoObj = new departamentoModel();
    }
    
    public function listar(){
        $this->tituloVista = 'Listado de Bailes';
        return [
            'bailes' => $this->baileObj->getAllBailes(),
            'departamentos' => $this->departamentoObj->getAllDepartamentos()
        ];
    }
    
    public function crear(){
        $this->tituloVista = 'Crear Nuevo Baile';
        $this->view = "bailes/baileForm";
        
        if($_POST){
            $data = [
                'nombre' => $_POST['nombre'],
                'ritmo' => $_POST['ritmo']
            ];
            
            $id_baile = $this->baileObj->createBaile($data);
            
            // Asignar relación con departamento
            if($id_baile && isset($_POST['id_departamento'])){
                $this->baileObj->asignarDepartamento($id_baile, $_POST['id_departamento']);
            }
            
            if($id_baile){
                header("Location: index.php?controller=baileController&funcion=listar");
            }
        }
        
        return ['departamentos' => $this->departamentoObj->getAllDepartamentos()];
    }
    
    public function editar(){
        $this->tituloVista = 'Editar Baile';
        $this->view = "bailes/baileForm";
        
        $id = $_GET['id'] ?? null;
        
        if($_POST && $id){
            $data = [
                'nombre' => $_POST['nombre'],
                'ritmo' => $_POST['ritmo']
            ];
            
            if($this->baileObj->updateBaile($id, $data)){
                header("Location: index.php?controller=baileController&funcion=listar");
            }
        }
        
        return [
            'baile' => $this->baileObj->getBaileById($id),
            'departamentos' => $this->departamentoObj->getAllDepartamentos()
        ];
    }
    
    public function eliminar(){
        $id = $_GET['id'] ?? null;
        if($id && $this->baileObj->deleteBaile($id)){
            header("Location: index.php?controller=baileController&funcion=listar");
        }
        return [];
    }
}
?>