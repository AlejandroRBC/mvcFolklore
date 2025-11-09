<?php
require_once('app/Models/bailarinModel.php');
require_once('app/Models/fraternidadModel.php');

class bailarinController{
    public $view = "bailarines/bailarinView";
    public $tituloVista;
    public $bailarinObj;
    public $fraternidadObj;
    
    public function __construct(){
        $this->bailarinObj = new bailarinModel();
        $this->fraternidadObj = new fraternidadModel();
    }
    
    public function listar(){
        $this->tituloVista = 'Listado de Bailarines';
        return [
            'bailarines' => $this->bailarinObj->getAllBailarines(),
            'fraternidades' => $this->fraternidadObj->getAllFraternidades()
        ];
    }
    
    public function crear(){
        $this->tituloVista = 'Crear Bailarín';
        $this->view = "bailarines/bailarinForm";
        
        if($_POST){
            $data = [
                'ci_bailarin' => $_POST['ci_bailarin'],
                'nombre' => $_POST['nombre'],
                'fec_nac' => $_POST['fec_nac']
            ];
            
            if($this->bailarinObj->createBailarin($data)){
                // Asignar a fraternidad si se seleccionó
                if(isset($_POST['id_fraternidad'])){
                    $this->bailarinObj->asignarFraternidad($_POST['ci_bailarin'], $_POST['id_fraternidad']);
                }
                header("Location: index.php?controller=bailarinController&funcion=listar");
            }
        }
        
        return ['fraternidades' => $this->fraternidadObj->getAllFraternidades()];
    }
    
    public function editar(){
        $this->tituloVista = 'Editar Bailarín';
        $this->view = "bailarines/bailarinForm";
        
        $ci = $_GET['ci'] ?? null;
        
        if($_POST && $ci){
            $data = [
                'nombre' => $_POST['nombre'],
                'fec_nac' => $_POST['fec_nac']
            ];
            
            if($this->bailarinObj->updateBailarin($ci, $data)){
                header("Location: index.php?controller=bailarinController&funcion=listar");
            }
        }
        
        return [
            'bailarin' => $this->bailarinObj->getBailarinById($ci),
            'fraternidades' => $this->fraternidadObj->getAllFraternidades()
        ];
    }
    
    public function eliminar(){
        $ci = $_GET['ci'] ?? null;
        if($ci && $this->bailarinObj->deleteBailarin($ci)){
            header("Location: index.php?controller=bailarinController&funcion=listar");
        }
        return [];
    }
}
?>