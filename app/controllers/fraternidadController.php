<?php
require_once('app/Models/fraternidadModel.php');
require_once('app/Models/baileModel.php');
require_once('app/Models/bailarinModel.php');

class fraternidadController{
    public $view = "fraternidades/fraternidadView";
    public $tituloVista;
    public $fraternidadObj;
    public $baileObj;
    public $bailarinObj;
    
    public function __construct(){
        $this->fraternidadObj = new fraternidadModel();
        $this->baileObj = new baileModel();
        $this->bailarinObj = new bailarinModel();
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
            'bailes' => $this->baileObj->getAllBailes(),
            'bailarines' => $this->fraternidadObj->getBailarinesByFraternidad($id)
        ];
    }
    
    public function eliminar(){
        $id = $_GET['id'] ?? null;
        if($id && $this->fraternidadObj->deleteFraternidad($id)){
            header("Location: index.php?controller=fraternidadController&funcion=listar");
        }
        return [];
    }
    
    public function gestionarBailarines(){
        $this->tituloVista = 'Gestionar Bailarines de Fraternidad';
        $this->view = "fraternidades/gestionarBailarines";
        
        $id_fraternidad = $_GET['id'] ?? null;
        
        if($_POST && $id_fraternidad){
            // Asignar nuevo bailarín
            if(isset($_POST['nuevo_bailarin']) && !empty($_POST['nuevo_bailarin'])){
                $this->fraternidadObj->asignarBailarin($id_fraternidad, $_POST['nuevo_bailarin']);
            }
            
            // Eliminar bailarín
            if(isset($_POST['eliminar_bailarin']) && !empty($_POST['eliminar_bailarin'])){
                $this->fraternidadObj->eliminarBailarin($id_fraternidad, $_POST['eliminar_bailarin']);
            }
            
            header("Location: index.php?controller=fraternidadController&funcion=gestionarBailarines&id=" . $id_fraternidad);
        }
        
        return [
            'fraternidad' => $this->fraternidadObj->getFraternidadById($id_fraternidad),
            'bailarines_fraternidad' => $this->fraternidadObj->getBailarinesByFraternidad($id_fraternidad),
            'todos_bailarines' => $this->bailarinObj->getAllBailarines()
        ];
    }
    public function detalle(){
        $this->tituloVista = 'Detalle de Fraternidad';
        $this->view = "fraternidades/fraternidadDetalle";
        
        $id = $_GET['id'] ?? null;
        
        if(!$id){
            return ['error' => 'Fraternidad no especificada'];
        }
        
        $fraternidad = $this->fraternidadObj->getFraternidadById($id);
        if(!$fraternidad){
            return ['error' => 'Fraternidad no encontrada'];
        }
        
        return [
            'fraternidad' => $fraternidad,
            'bailarines' => $this->fraternidadObj->getBailarinesByFraternidad($id),
            'bailes' => $this->baileObj->getAllBailes()
        ];
    }
}
?>