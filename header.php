<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo constant("SITE_NAME"); ?></title>
    <style>
        nav { background: #333; padding: 10px; }
        nav a { color: white; margin: 0 10px; text-decoration: none; }
        nav a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="index.php?controller=baileController&funcion=listar">Bailes</a>
        <a href="index.php?controller=fraternidadController&funcion=listar">Fraternidades</a>
        <a href="index.php?controller=bailarinController&funcion=listar">Bailarines</a>
        <a href="index.php?controller=departamentoController&funcion=listar">Departamentos</a>
        <a href="index.php?controller=entradaController&funcion=listar">Entradas</a>
    </nav>
    
    <h1><?php echo $controllerDinamico->tituloVista; ?></h1>