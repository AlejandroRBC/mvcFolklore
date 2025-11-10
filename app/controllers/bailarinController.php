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
        $bailarines = $this->bailarinObj->getAllBailarines();
        
        // Calcular edad para cada bailarín
        foreach($bailarines as &$bailarin) {
            $bailarin['edad'] = $this->bailarinObj->calcularEdad($bailarin['fec_nac']);
        }
        
        return [
            'bailarines' => $bailarines,
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
                // Asignar a fraternidades si se seleccionaron
                if(isset($_POST['id_fraternidad']) && is_array($_POST['id_fraternidad'])){
                    foreach($_POST['id_fraternidad'] as $id_fraternidad){
                        if(!empty($id_fraternidad)){
                            $this->bailarinObj->asignarFraternidad($_POST['ci_bailarin'], $id_fraternidad);
                        }
                    }
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
                // Actualizar fraternidades
                if(isset($_POST['id_fraternidad']) && is_array($_POST['id_fraternidad'])){
                    // Primero eliminar todas las fraternidades actuales
                    $fraternidadesActuales = $this->bailarinObj->getFraternidadesByBailarin($ci);
                    foreach($fraternidadesActuales as $fraternidad){
                        $this->bailarinObj->eliminarFraternidad($ci, $fraternidad['id_fraternidad']);
                    }
                    
                    // Luego agregar las nuevas fraternidades
                    foreach($_POST['id_fraternidad'] as $id_fraternidad){
                        if(!empty($id_fraternidad)){
                            $this->bailarinObj->asignarFraternidad($ci, $id_fraternidad);
                        }
                    }
                }
                
                header("Location: index.php?controller=bailarinController&funcion=listar");
            }
        }
        
        $bailarin = $this->bailarinObj->getBailarinById($ci);
        if($bailarin) {
            $bailarin['edad'] = $this->bailarinObj->calcularEdad($bailarin['fec_nac']);
        }
        
        return [
            'bailarin' => $bailarin,
            'fraternidades_bailarin' => $this->bailarinObj->getFraternidadesByBailarin($ci),
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
    
    public function detalle(){
        $this->tituloVista = 'Detalle del Bailarín';
        $this->view = "bailarines/bailarinDetalle";
        
        $ci = $_GET['ci'] ?? null;
        
        $bailarin = $this->bailarinObj->getBailarinById($ci);
        if($bailarin) {
            $bailarin['edad'] = $this->bailarinObj->calcularEdad($bailarin['fec_nac']);
        }
        
        return [
            'bailarin' => $bailarin,
            'fraternidades' => $this->bailarinObj->getFraternidadesByBailarin($ci)
        ];
    }
}
?>