<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bailes</title>
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
        .search-box { margin-bottom: 20px; padding: 10px; background: #f8f9fa; border-radius: 5px; }
        .ritmo-badge { background-color: #28a745; color: white; padding: 3px 8px; border-radius: 10px; font-size: 10px; text-transform: uppercase; }
    </style>
</head>
<body>
    <h2>Bailes Tradicionales Bolivianos</h2>
    <a href="index.php?controller=baileController&funcion=crear" class="btn btn-success">Nuevo Baile</a>

    
    <a href="index.php?controller=baileController&funcion=buscar" class="btn btn-info">Buscar Bailes</a>
    
    <div class="stats">
        <div class="stat-card">
            <h4>Total Bailes</h4>
            <p style="font-size: 24px; margin: 0; font-weight: bold;">
                <?php echo count($infoParaVer["datos"]['bailes'] ?? []); ?>
            </p>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Ritmo</th>
                <th>Departamentos</th>
                <th>Total Deptos.</th>
                <th>Fraternidades</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php  
            if(isset($infoParaVer["datos"]['bailes']) && is_array($infoParaVer["datos"]['bailes'])):
                foreach($infoParaVer["datos"]['bailes'] as $baile): ?>
                    <tr>
                        <td><?php echo $baile['id_baile']; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($baile['nombre']); ?></strong>
                        </td>
                        <td>
                            <?php if(!empty($baile['ritmo'])): ?>
                                <span class="ritmo-badge"><?php echo htmlspecialchars($baile['ritmo']); ?></span>
                            <?php else: ?>
                                <span class="badge">Sin ritmo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($baile['departamentos'])): ?>
                                <?php echo htmlspecialchars($baile['departamentos']); ?>
                            <?php else: ?>
                                <span class="badge">Sin departamentos</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge"><?php echo $baile['total_departamentos'] ?? 0; ?></span>
                        </td>
                        <td>
                            <span class="badge"><?php echo $baile['total_fraternidades'] ?? 0; ?></span>
                        </td>
                        <td>
                            <a href="index.php?controller=baileController&funcion=detalle&id=<?php echo $baile['id_baile']; ?>" class="btn btn-info">Ver</a>
                            <a href="index.php?controller=baileController&funcion=editar&id=<?php echo $baile['id_baile']; ?>" class="btn btn-primary">Editar</a>
                            <a href="index.php?controller=baileController&funcion=gestionarDepartamentos&id=<?php echo $baile['id_baile']; ?>" class="btn btn-warning">Deptos.</a>
                            <a href="index.php?controller=baileController&funcion=eliminar&id=<?php echo $baile['id_baile']; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este baile? Se eliminarán todas las relaciones con departamentos.')">Eliminar</a>
                        </td>
                    </tr>
            <?php endforeach; 
            else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay bailes registrados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>