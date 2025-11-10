<?php
require_once('app/Models/baileModel.php');
require_once('app/Models/departamentoModel.php');
require_once('app/Models/fraternidadModel.php');

class baileController{
    public $view = "bailes/baileView";
    public $tituloVista;
    public $baileObj;
    public $departamentoObj;
    public $fraternidadObj;
    
    public function __construct(){
        $this->baileObj = new baileModel();
        $this->departamentoObj = new departamentoModel();
        $this->fraternidadObj = new fraternidadModel();
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
            
            // Asignar relación con departamentos
            if($id_baile && isset($_POST['id_departamento']) && is_array($_POST['id_departamento'])){
                foreach($_POST['id_departamento'] as $id_departamento){
                    if(!empty($id_departamento)){
                        $this->baileObj->asignarDepartamento($id_baile, $id_departamento);
                    }
                }
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
                // Actualizar departamentos
                if(isset($_POST['id_departamento']) && is_array($_POST['id_departamento'])){
                    // Primero eliminar todos los departamentos actuales
                    $departamentosActuales = $this->baileObj->getDepartamentosByBaile($id);
                    foreach($departamentosActuales as $departamento){
                        $this->baileObj->eliminarDepartamento($id, $departamento['id_departamento']);
                    }
                    
                    // Luego agregar los nuevos departamentos
                    foreach($_POST['id_departamento'] as $id_departamento){
                        if(!empty($id_departamento)){
                            $this->baileObj->asignarDepartamento($id, $id_departamento);
                        }
                    }
                }
                
                header("Location: index.php?controller=baileController&funcion=listar");
            }
        }
        
        return [
            'baile' => $this->baileObj->getBaileById($id),
            'departamentos_baile' => $this->baileObj->getDepartamentosByBaile($id),
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
    
    public function detalle(){
        $this->tituloVista = 'Detalle del Baile';
        $this->view = "bailes/baileDetalle";
        
        $id = $_GET['id'] ?? null;
        
        return [
            'baile' => $this->baileObj->getBaileById($id),
            'departamentos' => $this->baileObj->getDepartamentosByBaile($id),
            'fraternidades' => $this->baileObj->getFraternidadesByBaile($id)
        ];
    }
    
    public function gestionarDepartamentos(){
        $this->tituloVista = 'Gestionar Departamentos del Baile';
        $this->view = "bailes/gestionarDepartamentos";
        
        $id_baile = $_GET['id'] ?? null;
        
        if($_POST && $id_baile){
            // Asignar nuevo departamento
            if(isset($_POST['nuevo_departamento']) && !empty($_POST['nuevo_departamento'])){
                $this->baileObj->asignarDepartamento($id_baile, $_POST['nuevo_departamento']);
            }
            
            // Eliminar departamento
            if(isset($_POST['eliminar_departamento']) && !empty($_POST['eliminar_departamento'])){
                $this->baileObj->eliminarDepartamento($id_baile, $_POST['eliminar_departamento']);
            }
            
            header("Location: index.php?controller=baileController&funcion=gestionarDepartamentos&id=" . $id_baile);
        }
        
        return [
            'baile' => $this->baileObj->getBaileById($id_baile),
            'departamentos_baile' => $this->baileObj->getDepartamentosByBaile($id_baile),
            'todos_departamentos' => $this->departamentoObj->getAllDepartamentos()
        ];
    }
    
    public function buscar(){
        $this->tituloVista = 'Buscar Bailes';
        $this->view = "bailes/buscarBaile";
        
        $resultados = [];
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $resultados = $this->baileObj->buscarBailes($_GET['q']);
        }
        
        return [
            'resultados' => $resultados,
            'termino' => $_GET['q'] ?? ''
        ];
    }
}
?>