    <?php 

    // Iniciar sesión al principio del archivo
    session_start();    
    require_once 'app/config/config.php';
    require_once 'app/models/db.php';

    // cargar valores default de config.php
    if(!isset($_GET["controller"]))
        $_GET["controller"] = constant("DEFAULT_CONTROLLER");
    if(!isset($_GET["funcion"]))
        $_GET["funcion"] = constant("DEFAULT_ACTION");

    // Definir la ruta del controlador dinámicamente
    $controllerName = $_GET["controller"];
    $controller_path = 'app/controllers/'.$controllerName.'.php';
    
    /* Ver si existe el controlador */
    if(!file_exists($controller_path)) {
        die("Controlador no encontrado: " . $controller_path);
    }

    /* cargar controlador */
    require_once $controller_path;
    $controllerDinamico = new $controllerName();

    /* Verificar si existe el metodo en el controlador dinamico y cargar los datos */
    $infoParaVer["data"] = array();
    if(method_exists($controllerDinamico, $_GET["funcion"])) {
        $infoParaVer["datos"] = $controllerDinamico->{$_GET["funcion"]}();
    } else {
        die("Método no encontrado: " . $_GET["funcion"]);
    }

    // Cargar vistas
    require_once 'header.php';
    /* Cargar las vistas de la funciones del controlador dinamico */
    require_once 'app/Views/'.$controllerDinamico->view.'.php';
    require_once 'footer.php';
?>