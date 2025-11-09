<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Baile</title>
</head>
<body>
    <h2><?php echo $controllerDinamico->tituloVista; ?></h2>
    
    <form method="POST">
        <div>
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $infoParaVer['datos']['nombre'] ?? ''; ?>" required>
        </div>
        
        <div>
            <label>Ritmo:</label>
            <input type="text" name="ritmo" value="<?php echo $infoParaVer['datos']['ritmo'] ?? ''; ?>">
        </div>
        
        
        
        
        
        <button type="submit">Guardar</button>
        <a href="index.php?controller=baileController&funcion=listar">Cancelar</a>
    </form>
</body>
</html>