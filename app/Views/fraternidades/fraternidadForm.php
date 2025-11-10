<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Fraternidad</title>
    <style>
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { padding: 8px; width: 100%; max-width: 300px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
    </style>
</head>
<body>
    <h2><?php echo $controllerDinamico->tituloVista; ?></h2>
    
    <form method="POST">
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $infoParaVer['datos']['fraternidad']['nombre'] ?? ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Fecha de Creación:</label>
            <input type="date" name="fecha_creacion" value="<?php echo $infoParaVer['datos']['fraternidad']['fecha_creacion'] ?? ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Baile:</label>
            <select name="id_baile" required>
                <option value="">Seleccionar Baile</option>
                <?php if(isset($infoParaVer['datos']['bailes'])): ?>
                    <?php foreach($infoParaVer['datos']['bailes'] as $baile): ?>
                        <option value="<?php echo $baile['id_baile']; ?>" 
                            <?php echo (isset($infoParaVer['datos']['fraternidad']['id_baile']) && $infoParaVer['datos']['fraternidad']['id_baile'] == $baile['id_baile']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($baile['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="index.php?controller=fraternidadController&funcion=listar" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</body>
</html>