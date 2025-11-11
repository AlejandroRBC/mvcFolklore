<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fraternidades</title>
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
    </style>
</head>
<body>
    <h2>Fraternidades</h2>
    <a href="index.php?controller=fraternidadController&funcion=crear" class="btn btn-success">Nueva Fraternidad</a>
    
    <div class="stats">
        <div class="stat-card">
            <h4>Total Fraternidades</h4>
            <p style="font-size: 24px; margin: 0; font-weight: bold;">
                <?php echo count($infoParaVer["datos"]['fraternidades'] ?? []); ?>
            </p>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha Creación</th>
                <th>Baile</th>
                <th>Bailarines</th>
                <th>Entradas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php  
            if(isset($infoParaVer["datos"]['fraternidades']) && is_array($infoParaVer["datos"]['fraternidades'])):
                foreach($infoParaVer["datos"]['fraternidades'] as $fraternidad): ?>
                    <tr>
                        <td><?php echo $fraternidad['id_fraternidad']; ?></td>
                        <td><?php echo htmlspecialchars($fraternidad['nombre']); ?></td>
                        <td><?php echo $fraternidad['fecha_creacion']; ?></td>
                        <td>
                            <?php if(!empty($fraternidad['nombre_baile'])): ?>
                                <?php echo htmlspecialchars($fraternidad['nombre_baile']); ?>
                            <?php else: ?>
                                <span class="badge">Sin baile</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($fraternidad['total_bailarines'] > 0): ?>
                                <span class="badge"><?php echo $fraternidad['total_bailarines']; ?> bailarines</span>
                            <?php else: ?>
                                <span class="badge">Sin bailarines</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($fraternidad['entradas'])): ?>
                                <?php echo htmlspecialchars($fraternidad['entradas']); ?>
                            <?php else: ?>
                                <span class="badge">Sin entradas</span>
                            <?php endif; ?>
                        </td>
                        <td>
    <a href="index.php?controller=fraternidadController&funcion=detalle&id=<?php echo $fraternidad['id_fraternidad']; ?>" class="btn btn-info">Ver</a>
    <a href="index.php?controller=fraternidadController&funcion=editar&id=<?php echo $fraternidad['id_fraternidad']; ?>" class="btn btn-primary">Editar</a>
    <?php if(isset($_SESSION['logged_in'])): ?>
        <a href="index.php?controller=puntuacionController&funcion=puntuar&id=<?php echo $fraternidad['id_fraternidad']; ?>" class="btn btn-warning">Puntuar</a>
    <?php endif; ?>
    <a href="index.php?controller=fraternidadController&funcion=eliminar&id=<?php echo $fraternidad['id_fraternidad']; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar esta fraternidad? Se eliminarán todos los bailarines asociados.')">Eliminar</a>
</td>
            <?php endforeach; 
            else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay fraternidades registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>