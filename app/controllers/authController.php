<?php
require_once('app/Models/usuarioModel.php');

class authController{
    public $view = "auth/login";
    public $tituloVista;
    public $usuarioObj;
    
    public function __construct(){
        $this->usuarioObj = new usuarioModel();
    }
    
    public function login(){
        $this->tituloVista = 'Iniciar Sesión';
        $this->view = "auth/login";
        
        if($_POST){
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $usuario = $this->usuarioObj->getUserByUsername($username);
            
            if($usuario && $this->usuarioObj->verifyPassword($password, $usuario['password'])){
                // Iniciar sesión
                
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['username'] = $usuario['username'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['es_admin'] = $usuario['es_admin'];
                $_SESSION['logged_in'] = true;
                
                header("Location: index.php?controller=fraternidadController&funcion=listar");
                exit();
            } else {
                return ['error' => 'Usuario o contraseña incorrectos'];
            }
        }
        
        return [];
    }
    
    public function register(){
        $this->tituloVista = 'Registrar Usuario';
        $this->view = "auth/register";
        
        if($_POST){
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'nombre' => $_POST['nombre'],
                'apellido' => $_POST['apellido']
            ];
            
            // Validaciones básicas
            if(empty($data['username']) || empty($data['email']) || empty($data['password'])){
                return ['error' => 'Todos los campos son obligatorios'];
            }
            
            if($this->usuarioObj->createUser($data)){
                return ['success' => 'Usuario registrado correctamente. Ahora puedes iniciar sesión.'];
            } else {
                return ['error' => 'Error al registrar el usuario. El username o email ya existen.'];
            }
        }
        
        return [];
    }
    
    public function logout(){
        
        session_destroy();
        header("Location: index.php?controller=authController&funcion=login");
        exit();
    }
    
    public function perfil(){
        
        if(!isset($_SESSION['logged_in'])){
            header("Location: index.php?controller=authController&funcion=login");
            exit();
        }
        
        $this->tituloVista = 'Mi Perfil';
        $this->view = "auth/perfil";
        
        $usuario_id = $_SESSION['usuario_id'];
        
        return [
            'usuario' => $this->usuarioObj->getUserById($usuario_id),
            'puntuaciones' => $this->usuarioObj->getUserPuntuaciones($usuario_id)
        ];
    }
}
?>