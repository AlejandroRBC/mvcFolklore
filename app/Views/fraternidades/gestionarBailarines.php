<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Bailarines</title>
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
        <h3>Fraternidad: <?php echo htmlspecialchars($infoParaVer['datos']['fraternidad']['nombre'] ?? ''); ?></h3>
        <a href="index.php?controller=fraternidadController&funcion=listar" class="btn btn-secondary">Volver al Listado</a>
    </div>
    
    <div class="section">
        <h4>Agregar Bailarín</h4>
        <form method="POST">
            <div class="form-group">
                <label>Seleccionar Bailarín:</label>
                <select name="nuevo_bailarin" required>
                    <option value="">Seleccionar Bailarín</option>
                    <?php if(isset($infoParaVer['datos']['todos_bailarines'])): ?>
                        <?php foreach($infoParaVer['datos']['todos_bailarines'] as $bailarin): ?>
                            <option value="<?php echo $bailarin['ci_bailarin']; ?>">
                                <?php echo htmlspecialchars($bailarin['nombre'] . ' (CI: ' . $bailarin['ci_bailarin'] . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Agregar Bailarín</button>
        </form>
    </div>
    
    <div class="section">
        <h4>Bailarines de la Fraternidad</h4>
        <?php if(isset($infoParaVer['datos']['bailarines_fraternidad']) && !empty($infoParaVer['datos']['bailarines_fraternidad'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Fecha Nacimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($infoParaVer['datos']['bailarines_fraternidad'] as $bailarin): ?>
                        <tr>
                            <td><?php echo $bailarin['ci_bailarin']; ?></td>
                            <td><?php echo htmlspecialchars($bailarin['nombre']); ?></td>
                            <td><?php echo $bailarin['fec_nac']; ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="eliminar_bailarin" value="<?php echo $bailarin['ci_bailarin']; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este bailarín de la fraternidad?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay bailarines en esta fraternidad.</p>
        <?php endif; ?>
    </div>
</body>
</html>