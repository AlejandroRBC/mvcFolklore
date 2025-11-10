<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Bailes</title>
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
        <h3>Departamento: <?php echo htmlspecialchars($infoParaVer['datos']['departamento']['nombre'] ?? ''); ?></h3>
        <a href="index.php?controller=departamentoController&funcion=listar" class="btn btn-secondary">Volver al Listado</a>
    </div>
    
    <div class="section">
        <h4>Agregar Baile al Departamento</h4>
        <form method="POST">
            <div class="form-group">
                <label>Seleccionar Baile:</label>
                <select name="nuevo_baile" required>
                    <option value="">Seleccionar Baile</option>
                    <?php if(isset($infoParaVer['datos']['todos_bailes'])): ?>
                        <?php foreach($infoParaVer['datos']['todos_bailes'] as $baile): ?>
                            <option value="<?php echo $baile['id_baile']; ?>">
                                <?php echo htmlspecialchars($baile['nombre'] . ' (' . ($baile['ritmo'] ?? 'Sin ritmo') . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Agregar Baile</button>
        </form>
    </div>
    
    <div class="section">
        <h4>Bailes del Departamento</h4>
        <?php if(isset($infoParaVer['datos']['bailes_departamento']) && !empty($infoParaVer['datos']['bailes_departamento'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ritmo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($infoParaVer['datos']['bailes_departamento'] as $baile): ?>
                        <tr>
                            <td><?php echo $baile['id_baile']; ?></td>
                            <td><?php echo htmlspecialchars($baile['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($baile['ritmo'] ?? 'No especificado'); ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="eliminar_baile" value="<?php echo $baile['id_baile']; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este baile del departamento?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay bailes asignados a este departamento.</p>
        <?php endif; ?>
    </div>
</body>
</html>