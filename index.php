<?php 
    require_once 'app/config/config.php';
    require_once 'app/models/db.php';

    // cargar valores default de config.php
    if(!isset($_GET["controller"]))
        $_GET["controller"] = constant("DEFAULT_CONTROLLER");
    if(!isset($_GET["funcion"]))
        $_GET["funcion"] = constant("DEFAULT_ACTION");

    // Definiar la ruta del controlador dinamicamente
    $controller_path = 'app/controllers/'.$_GET["controller"].'.php';

    /* Ver si existe el controlador */
    if(!file_exists($controller_path)) 
        $controller_path = 'controller/'.constant("DEFAULT_CONTROLLER").'.php';

    /* cargar controlador */
    require_once $controller_path;
    $controllerName = $_GET["controller"];
    $controllerDinamico = new $controllerName();

    /* Verificar si existe el metodo en el controlador dinamico */
    $dataToView["data"] = array();
    if(method_exists($controllerDinamico,$_GET["funcion"]))
        $dataToView["data"] = $controllerDinamico->{$_GET["funcion"]}();

    // Cargar vistas
    require_once 'header.php';
    /* Cargar las vistas de la funciones del controlador dinamico */
    require_once 'view/'.$controllerDinamico -> view.'.php';
    require_once 'footer.php';

?>