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
            if($id_entrada && isset($_POST['id_fraternidad']) && isset($_POST['hora'])){
                $this->entradaObj->asignarCronograma($id_entrada, $_POST['id_fraternidad'], $_POST['hora']);
            }
            
            if($id_entrada){
                header("Location: index.php?controller=entradaController&funcion=listar");
            }
        }
        
        return ['fraternidades' => $this->fraternidadObj->getAllFraternidades()];
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