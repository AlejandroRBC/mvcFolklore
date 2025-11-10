<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 2px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-info { background-color: #17a2b8; color: white; }
        .btn-warning { background-color: #ffc107; color: black; }
        .badge { background-color: #6c757d; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
        .stats { display: flex; gap: 15px; margin-bottom: 15px; }
        .stat-card { background: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #007bff; }
        .region-badge { 
            background-color: #28a745; 
            color: white; 
            padding: 3px 8px; 
            border-radius: 10px; 
            font-size: 10px; 
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <h2>Departamentos de Bolivia</h2>
    <a href="index.php?controller=departamentoController&funcion=crear" class="btn btn-success">Nuevo Departamento</a>
    <a href="index.php?controller=departamentoController&funcion=estadisticas" class="btn btn-info">Ver Estadísticas</a>
    
    <div class="stats">
        <div class="stat-card">
            <h4>Total Departamentos</h4>
            <p style="font-size: 24px; margin: 0; font-weight: bold;">
                <?php echo count($infoParaVer["datos"]['departamentos'] ?? []); ?>
            </p>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Región</th>
                <th>Bailes</th>
                <th>Total Bailes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php  
            if(isset($infoParaVer["datos"]['departamentos']) && is_array($infoParaVer["datos"]['departamentos'])):
                foreach($infoParaVer["datos"]['departamentos'] as $departamento): ?>
                    <tr>
                        <td><?php echo $departamento['id_departamento']; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($departamento['nombre']); ?></strong>
                        </td>
                        <td>
                            <?php if(!empty($departamento['region'])): ?>
                                <span class="region-badge"><?php echo htmlspecialchars($departamento['region']); ?></span>
                            <?php else: ?>
                                <span class="badge">Sin región</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($departamento['bailes'])): ?>
                                <?php echo htmlspecialchars($departamento['bailes']); ?>
                            <?php else: ?>
                                <span class="badge">Sin bailes</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge"><?php echo $departamento['total_bailes'] ?? 0; ?></span>
                        </td>
                        <td>
                            <a href="index.php?controller=departamentoController&funcion=detalle&id=<?php echo $departamento['id_departamento']; ?>" class="btn btn-info">Ver</a>
                            <a href="index.php?controller=departamentoController&funcion=editar&id=<?php echo $departamento['id_departamento']; ?>" class="btn btn-primary">Editar</a>
                            <a href="index.php?controller=departamentoController&funcion=gestionarBailes&id=<?php echo $departamento['id_departamento']; ?>" class="btn btn-warning">Bailes</a>
                            <a href="index.php?controller=departamentoController&funcion=eliminar&id=<?php echo $departamento['id_departamento']; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este departamento? Se eliminarán todas las relaciones con bailes.')">Eliminar</a>
                        </td>
                    </tr>
            <?php endforeach; 
            else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No hay departamentos registrados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>