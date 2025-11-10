<?php
require_once('app/Models/departamentoModel.php');
require_once('app/Models/baileModel.php');

class departamentoController{
    public $view = "departamentos/departamentoView";
    public $tituloVista;
    public $departamentoObj;
    public $baileObj;
    
    public function __construct(){
        $this->departamentoObj = new departamentoModel();
        $this->baileObj = new baileModel();
    }
    
    public function listar(){
        $this->tituloVista = 'Listado de Departamentos';
        return [
            'departamentos' => $this->departamentoObj->getAllDepartamentos(),
            'bailes' => $this->baileObj->getAllBailes()
        ];
    }
    
    public function crear(){
        $this->tituloVista = 'Crear Departamento';
        $this->view = "departamentos/departamentoForm";
        
        if($_POST){
            $data = [
                'nombre' => $_POST['nombre'],
                'region' => $_POST['region']
            ];
            
            $id_departamento = $this->departamentoObj->createDepartamento($data);
            
            // Asignar bailes si se seleccionaron
            if($id_departamento && isset($_POST['id_baile']) && is_array($_POST['id_baile'])){
                foreach($_POST['id_baile'] as $id_baile){
                    if(!empty($id_baile)){
                        $this->departamentoObj->asignarBaile($id_departamento, $id_baile);
                    }
                }
            }
            
            if($id_departamento){
                header("Location: index.php?controller=departamentoController&funcion=listar");
            }
        }
        
        return ['bailes' => $this->baileObj->getAllBailes()];
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
                // Actualizar bailes
                if(isset($_POST['id_baile']) && is_array($_POST['id_baile'])){
                    // Primero eliminar todos los bailes actuales
                    $bailesActuales = $this->departamentoObj->getBailesByDepartamento($id);
                    foreach($bailesActuales as $baile){
                        $this->departamentoObj->eliminarBaile($id, $baile['id_baile']);
                    }
                    
                    // Luego agregar los nuevos bailes
                    foreach($_POST['id_baile'] as $id_baile){
                        if(!empty($id_baile)){
                            $this->departamentoObj->asignarBaile($id, $id_baile);
                        }
                    }
                }
                
                header("Location: index.php?controller=departamentoController&funcion=listar");
            }
        }
        
        return [
            'departamento' => $this->departamentoObj->getDepartamentoById($id),
            'bailes_departamento' => $this->departamentoObj->getBailesByDepartamento($id),
            'bailes' => $this->baileObj->getAllBailes()
        ];
    }
    
    public function eliminar(){
        $id = $_GET['id'] ?? null;
        if($id && $this->departamentoObj->deleteDepartamento($id)){
            header("Location: index.php?controller=departamentoController&funcion=listar");
        }
        return [];
    }
    
    public function detalle(){
        $this->tituloVista = 'Detalle del Departamento';
        $this->view = "departamentos/departamentoDetalle";
        
        $id = $_GET['id'] ?? null;
        
        return [
            'departamento' => $this->departamentoObj->getDepartamentoById($id),
            'bailes' => $this->departamentoObj->getBailesByDepartamento($id),
            'estadisticas' => $this->departamentoObj->getDepartamentosConEstadisticas()
        ];
    }
    
    public function gestionarBailes(){
        $this->tituloVista = 'Gestionar Bailes del Departamento';
        $this->view = "departamentos/gestionarBailes";
        
        $id_departamento = $_GET['id'] ?? null;
        
        if($_POST && $id_departamento){
            // Asignar nuevo baile
            if(isset($_POST['nuevo_baile']) && !empty($_POST['nuevo_baile'])){
                $this->departamentoObj->asignarBaile($id_departamento, $_POST['nuevo_baile']);
            }
            
            // Eliminar baile
            if(isset($_POST['eliminar_baile']) && !empty($_POST['eliminar_baile'])){
                $this->departamentoObj->eliminarBaile($id_departamento, $_POST['eliminar_baile']);
            }
            
            header("Location: index.php?controller=departamentoController&funcion=gestionarBailes&id=" . $id_departamento);
        }
        
        return [
            'departamento' => $this->departamentoObj->getDepartamentoById($id_departamento),
            'bailes_departamento' => $this->departamentoObj->getBailesByDepartamento($id_departamento),
            'todos_bailes' => $this->baileObj->getAllBailes()
        ];
    }
    
    public function estadisticas(){
        $this->tituloVista = 'Estadísticas de Departamentos';
        $this->view = "departamentos/estadisticasView";
        
        return [
            'departamentos' => $this->departamentoObj->getDepartamentosConEstadisticas()
        ];
    }
}
?>