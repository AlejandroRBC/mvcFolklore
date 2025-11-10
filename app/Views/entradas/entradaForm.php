<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Entrada</title>
    <style>
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { padding: 8px; width: 100%; max-width: 300px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .cronograma-item { border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 4px; background-color: #f8f9fa; }
        .btn-add { background-color: #17a2b8; color: white; margin-bottom: 15px; }
        .btn-remove { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <h2><?php echo $controllerDinamico->tituloVista; ?></h2>
    
    <form method="POST">
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $infoParaVer['datos']['entrada']['nombre'] ?? ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Gestión:</label>
            <input type="number" name="gestion" value="<?php echo $infoParaVer['datos']['entrada']['gestion'] ?? date('Y'); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Fecha:</label>
            <input type="date" name="fecha" value="<?php echo $infoParaVer['datos']['entrada']['fecha'] ?? ''; ?>" required>
        </div>
        
        <h3>Cronograma de Fraternidades</h3>
        <div id="cronograma-container">
            <?php 
            $cronogramaItems = $infoParaVer['datos']['cronograma'] ?? [null];
            foreach($cronogramaItems as $index => $crono): ?>
            <div class="cronograma-item">
                <div class="form-group">
                    <label>Fraternidad:</label>
                    <select name="id_fraternidad[]">
                        <option value="">Seleccionar Fraternidad</option>
                        <?php if(isset($infoParaVer['datos']['fraternidades'])): ?>
                            <?php foreach($infoParaVer['datos']['fraternidades'] as $fraternidad): ?>
                                <option value="<?php echo $fraternidad['id_fraternidad']; ?>" 
                                    <?php echo (isset($crono['id_fraternidad']) && $crono['id_fraternidad'] == $fraternidad['id_fraternidad']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($fraternidad['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Hora:</label>
                    <input type="time" name="hora[]" value="<?php echo $crono['hora'] ?? ''; ?>">
                </div>
                
                <?php if($index > 0): ?>
                    <button type="button" class="btn btn-remove" onclick="removeCronogramaItem(this)">Eliminar</button>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        
        <button type="button" class="btn btn-add" onclick="addCronogramaItem()">Agregar Fraternidad</button>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="index.php?controller=entradaController&funcion=listar" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

    <script>
        function addCronogramaItem() {
            const container = document.getElementById('cronograma-container');
            const newItem = document.createElement('div');
            newItem.className = 'cronograma-item';
            newItem.innerHTML = `
                <div class="form-group">
                    <label>Fraternidad:</label>
                    <select name="id_fraternidad[]">
                        <option value="">Seleccionar Fraternidad</option>
                        <?php if(isset($infoParaVer['datos']['fraternidades'])): ?>
                            <?php foreach($infoParaVer['datos']['fraternidades'] as $fraternidad): ?>
                                <option value="<?php echo $fraternidad['id_fraternidad']; ?>">
                                    <?php echo htmlspecialchars($fraternidad['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Hora:</label>
                    <input type="time" name="hora[]">
                </div>
                <button type="button" class="btn btn-remove" onclick="removeCronogramaItem(this)">Eliminar</button>
            `;
            container.appendChild(newItem);
        }

        function removeCronogramaItem(button) {
            button.parentElement.remove();
        }
    </script>
</body>
</html>