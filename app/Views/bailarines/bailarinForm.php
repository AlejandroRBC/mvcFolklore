<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Bailarín</title>
    <style>
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { padding: 8px; width: 100%; max-width: 300px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .fraternidad-item { margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .checkbox-group { max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <h2><?php echo $controllerDinamico->tituloVista; ?></h2>
    
    <form method="POST">
        <div class="form-group">
            <label>Cédula de Identidad (CI):</label>
            <input type="number" name="ci_bailarin" 
                   value="<?php echo $infoParaVer['datos']['bailarin']['ci_bailarin'] ?? ''; ?>" 
                   <?php echo isset($infoParaVer['datos']['bailarin']) ? 'readonly' : 'required'; ?>>
        </div>
        
        <div class="form-group">
            <label>Nombre Completo:</label>
            <input type="text" name="nombre" value="<?php echo $infoParaVer['datos']['bailarin']['nombre'] ?? ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Fecha de Nacimiento:</label>
            <input type="date" name="fec_nac" value="<?php echo $infoParaVer['datos']['bailarin']['fec_nac'] ?? ''; ?>" required>
        </div>
        
        <?php if(isset($infoParaVer['datos']['bailarin']['edad'])): ?>
        <div class="form-group">
            <label>Edad Calculada:</label>
            <input type="text" value="<?php echo $infoParaVer['datos']['bailarin']['edad']; ?> años" readonly style="background-color: #f8f9fa;">
        </div>
        <?php endif; ?>
        
        <div class="form-group">
            <label>Fraternidades:</label>
            <div class="checkbox-group">
                <?php if(isset($infoParaVer['datos']['fraternidades'])): ?>
                    <?php 
                    $fraternidadesBailarin = [];
                    if(isset($infoParaVer['datos']['fraternidades_bailarin'])) {
                        foreach($infoParaVer['datos']['fraternidades_bailarin'] as $fraternidad) {
                            $fraternidadesBailarin[] = $fraternidad['id_fraternidad'];
                        }
                    }
                    ?>
                    <?php foreach($infoParaVer['datos']['fraternidades'] as $fraternidad): ?>
                        <div class="fraternidad-item">
                            <label>
                                <input type="checkbox" name="id_fraternidad[]" 
                                       value="<?php echo $fraternidad['id_fraternidad']; ?>"
                                       <?php echo in_array($fraternidad['id_fraternidad'], $fraternidadesBailarin) ? 'checked' : ''; ?>>
                                <?php echo htmlspecialchars($fraternidad['nombre']); ?>
                                <?php if(!empty($fraternidad['nombre_baile'])): ?>
                                    <small>(Baile: <?php echo htmlspecialchars($fraternidad['nombre_baile']); ?>)</small>
                                <?php endif; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay fraternidades disponibles</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="index.php?controller=bailarinController&funcion=listar" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</body>
</html>