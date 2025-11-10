<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Departamento</title>
    <style>
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { padding: 8px; width: 100%; max-width: 300px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .baile-item { margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .checkbox-group { max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <h2><?php echo $controllerDinamico->tituloVista; ?></h2>
    
    <form method="POST">
        <div class="form-group">
            <label>Nombre del Departamento:</label>
            <input type="text" name="nombre" value="<?php echo $infoParaVer['datos']['departamento']['nombre'] ?? ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Región:</label>
            <select name="region">
                <option value="">Seleccionar Región</option>
                <option value="Andes" <?php echo (isset($infoParaVer['datos']['departamento']['region']) && $infoParaVer['datos']['departamento']['region'] == 'Andes') ? 'selected' : ''; ?>>Andes</option>
                <option value="Valle" <?php echo (isset($infoParaVer['datos']['departamento']['region']) && $infoParaVer['datos']['departamento']['region'] == 'Valle') ? 'selected' : ''; ?>>Valle</option>
                <option value="Llanos" <?php echo (isset($infoParaVer['datos']['departamento']['region']) && $infoParaVer['datos']['departamento']['region'] == 'Llanos') ? 'selected' : ''; ?>>Llanos</option>
                <option value="Amazonía" <?php echo (isset($infoParaVer['datos']['departamento']['region']) && $infoParaVer['datos']['departamento']['region'] == 'Amazonía') ? 'selected' : ''; ?>>Amazonía</option>
                <option value="Chaco" <?php echo (isset($infoParaVer['datos']['departamento']['region']) && $infoParaVer['datos']['departamento']['region'] == 'Chaco') ? 'selected' : ''; ?>>Chaco</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Bailes Típicos:</label>
            <div class="checkbox-group">
                <?php if(isset($infoParaVer['datos']['bailes'])): ?>
                    <?php 
                    $bailesDepartamento = [];
                    if(isset($infoParaVer['datos']['bailes_departamento'])) {
                        foreach($infoParaVer['datos']['bailes_departamento'] as $baile) {
                            $bailesDepartamento[] = $baile['id_baile'];
                        }
                    }
                    ?>
                    <?php foreach($infoParaVer['datos']['bailes'] as $baile): ?>
                        <div class="baile-item">
                            <label>
                                <input type="checkbox" name="id_baile[]" 
                                       value="<?php echo $baile['id_baile']; ?>"
                                       <?php echo in_array($baile['id_baile'], $bailesDepartamento) ? 'checked' : ''; ?>>
                                <?php echo htmlspecialchars($baile['nombre']); ?>
                                <?php if(!empty($baile['ritmo'])): ?>
                                    <small>(Ritmo: <?php echo htmlspecialchars($baile['ritmo']); ?>)</small>
                                <?php endif; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay bailes disponibles</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="index.php?controller=departamentoController&funcion=listar" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</body>
</html>