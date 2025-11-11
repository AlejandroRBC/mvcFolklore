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

<?php

$logged_in = $_SESSION['logged_in'] ?? false;
$username = $_SESSION['username'] ?? '';
$es_admin = $_SESSION['es_admin'] ?? false;
?>

<!-- Agregar después del nav existente -->
<div style="background: #f8f9fa; padding: 10px; text-align: right;">
    <?php if($logged_in): ?>
        Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong>
        | <a href="index.php?controller=authController&funcion=perfil">Mi Perfil</a>
        | <a href="index.php?controller=puntuacionController&funcion=ranking">Ranking</a>
        <?php if($es_admin): ?>
            | <a href="index.php?controller=fraternidadController&funcion=listar">Admin</a>
        <?php endif; ?>
        | <a href="index.php?controller=authController&funcion=logout">Cerrar Sesión</a>
    <?php else: ?>
        <a href="index.php?controller=authController&funcion=login">Iniciar Sesión</a>
        | <a href="index.php?controller=authController&funcion=register">Registrarse</a>
    <?php endif; ?>
</div>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="index.php?controller=baileController&funcion=listar">Bailes</a>
        <a href="index.php?controller=fraternidadController&funcion=listar">Fraternidades</a>
        <a href="index.php?controller=bailarinController&funcion=listar">Bailarines</a>
        <a href="index.php?controller=departamentoController&funcion=listar">Departamentos</a>
        <a href="index.php?controller=entradaController&funcion=listar">Entradas</a>
    </nav>
    
    <h1><?php echo $controllerDinamico->tituloVista; ?></h1>