<?php
require_once('app/Models/entradaModel.php');
require_once('app/Models/fraternidadModel.php');

class entradaController{
    public $view = "entradas/entradaView";
    public $tituloVista;
    public $entradaObj;
    public $fraternidadObj;
    
    public function __construct(){
        $this->entradaObj = new entradaModel();
        $this->fraternidadObj = new fraternidadModel();
    }
    
    public function listar(){
        $this->tituloVista = 'Listado de Entradas';
        return [
            'entradas' => $this->entradaObj->getAllEntradas(),
            'fraternidades' => $this->fraternidadObj->getAllFraternidades()
        ];
    }
    
    public function crear(){
        $this->tituloVista = 'Crear Entrada';
        $this->view = "entradas/entradaForm";
        
        if($_POST){
            $data = [
                'nombre' => $_POST['nombre'],
                'gestion' => $_POST['gestion'],
                'fecha' => $_POST['fecha']
            ];
            
            $id_entrada = $this->entradaObj->createEntrada($data);
            
            // Asignar fraternidades al cronograma
            if($id_entrada && isset($_POST['id_fraternidad']) && is_array($_POST['id_fraternidad'])){
                foreach($_POST['id_fraternidad'] as $index => $id_fraternidad){
                    if(!empty($id_fraternidad) && !empty($_POST['hora'][$index])){
                        $this->entradaObj->asignarCronograma($id_entrada, $id_fraternidad, $_POST['hora'][$index]);
                    }
                }
            }
            
            if($id_entrada){
                header("Location: index.php?controller=entradaController&funcion=listar");
            }
        }
        
        return ['fraternidades' => $this->fraternidadObj->getAllFraternidades()];
    }
    
    public function editar(){
        $this->tituloVista = 'Editar Entrada';
        $this->view = "entradas/entradaForm";
        
        $id = $_GET['id'] ?? null;
        
        if($_POST && $id){
            $data = [
                'nombre' => $_POST['nombre'],
                'gestion' => $_POST['gestion'],
                'fecha' => $_POST['fecha']
            ];
            
            if($this->entradaObj->updateEntrada($id, $data)){
                // Actualizar cronograma
                if(isset($_POST['id_fraternidad']) && is_array($_POST['id_fraternidad'])){
                    // Primero eliminar cronograma existente
                    $cronogramaActual = $this->entradaObj->getCronogramaByEntrada($id);
                    foreach($cronogramaActual as $crono){
                        $this->entradaObj->eliminarCronograma($id, $crono['id_fraternidad']);
                    }
                    
                    // Luego agregar nuevo cronograma
                    foreach($_POST['id_fraternidad'] as $index => $id_fraternidad){
                        if(!empty($id_fraternidad) && !empty($_POST['hora'][$index])){
                            $this->entradaObj->asignarCronograma($id, $id_fraternidad, $_POST['hora'][$index]);
                        }
                    }
                }
                
                header("Location: index.php?controller=entradaController&funcion=listar");
            }
        }
        
        return [
            'entrada' => $this->entradaObj->getEntradaById($id),
            'cronograma' => $this->entradaObj->getCronogramaByEntrada($id),
            'fraternidades' => $this->fraternidadObj->getAllFraternidades()
        ];
    }
    
    public function eliminar(){
        $id = $_GET['id'] ?? null;
        if($id && $this->entradaObj->deleteEntrada($id)){
            header("Location: index.php?controller=entradaController&funcion=listar");
        }
        return [];
    }
}
?>
