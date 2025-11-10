<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Departamentos</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 2px; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { padding: 8px; width: 100%; max-width: 300px; border: 1px solid #ddd; border-radius: 4px; }
        .section { background: #f8f9fa; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <h2><?php echo $controllerDinamico->tituloVista; ?></h2>
    
    <div class="section">
        <h3>Baile: <?php echo htmlspecialchars($infoParaVer['datos']['baile']['nombre'] ?? ''); ?></h3>
        <a href="index.php?controller=baileController&funcion=listar" class="btn btn-secondary">Volver al Listado</a>
    </div>
    
    <div class="section">
        <h4>Agregar Departamento al Baile</h4>
        <form method="POST">
            <div class="form-group">
                <label>Seleccionar Departamento:</label>
                <select name="nuevo_departamento" required>
                    <option value="">Seleccionar Departamento</option>
                    <?php if(isset($infoParaVer['datos']['todos_departamentos'])): ?>
                        <?php foreach($infoParaVer['datos']['todos_departamentos'] as $departamento): ?>
                            <option value="<?php echo $departamento['id_departamento']; ?>">
                                <?php echo htmlspecialchars($departamento['nombre'] . ' (' . ($departamento['region'] ?? 'Sin región') . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Agregar Departamento</button>
        </form>
    </div>
    
    <div class="section">
        <h4>Departamentos del Baile</h4>
        <?php if(isset($infoParaVer['datos']['departamentos_baile']) && !empty($infoParaVer['datos']['departamentos_baile'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Región</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($infoParaVer['datos']['departamentos_baile'] as $departamento): ?>
                        <tr>
                            <td><?php echo $departamento['id_departamento']; ?></td>
                            <td><?php echo htmlspecialchars($departamento['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($departamento['region'] ?? 'No especificada'); ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="eliminar_departamento" value="<?php echo $departamento['id_departamento']; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este departamento del baile?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay departamentos asignados a este baile.</p>
        <?php endif; ?>
    </div>
</body>
</html>