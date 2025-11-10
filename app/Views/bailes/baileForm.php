<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Baile</title>
    <style>
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { padding: 8px; width: 100%; max-width: 300px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .departamento-item { margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .checkbox-group { max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <h2><?php echo $controllerDinamico->tituloVista; ?></h2>
    
    <form method="POST">
        <div class="form-group">
            <label>Nombre del Baile:</label>
            <input type="text" name="nombre" value="<?php echo $infoParaVer['datos']['baile']['nombre'] ?? ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Ritmo:</label>
            <input type="text" name="ritmo" value="<?php echo $infoParaVer['datos']['baile']['ritmo'] ?? ''; ?>" placeholder="Ej: Caporal, Tinku, Morenada, etc.">
        </div>
        
        <div class="form-group">
            <label>Departamentos donde se baila:</label>
            <div class="checkbox-group">
                <?php if(isset($infoParaVer['datos']['departamentos'])): ?>
                    <?php 
                    $departamentosBaile = [];
                    if(isset($infoParaVer['datos']['departamentos_baile'])) {
                        foreach($infoParaVer['datos']['departamentos_baile'] as $departamento) {
                            $departamentosBaile[] = $departamento['id_departamento'];
                        }
                    }
                    ?>
                    <?php foreach($infoParaVer['datos']['departamentos'] as $departamento): ?>
                        <div class="departamento-item">
                            <label>
                                <input type="checkbox" name="id_departamento[]" 
                                       value="<?php echo $departamento['id_departamento']; ?>"
                                       <?php echo in_array($departamento['id_departamento'], $departamentosBaile) ? 'checked' : ''; ?>>
                                <?php echo htmlspecialchars($departamento['nombre']); ?>
                                <?php if(!empty($departamento['region'])): ?>
                                    <small>(Región: <?php echo htmlspecialchars($departamento['region']); ?>)</small>
                                <?php endif; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay departamentos disponibles</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="index.php?controller=baileController&funcion=listar" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</body>
</html>