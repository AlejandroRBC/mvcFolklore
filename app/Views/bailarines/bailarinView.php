<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bailarines</title>
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
    </style>
</head>
<body>
    <h2>Bailarines</h2>
    <a href="index.php?controller=bailarinController&funcion=crear" class="btn btn-success">Nuevo Bailarín</a>
    
    <div class="stats">
        <div class="stat-card">
            <h4>Total Bailarines</h4>
            <p style="font-size: 24px; margin: 0; font-weight: bold;">
                <?php echo count($infoParaVer["datos"]['bailarines'] ?? []); ?>
            </p>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>CI</th>
                <th>Nombre</th>
                <th>Fecha Nacimiento</th>
                <th>Edad</th>
                <th>Fraternidades</th>
                <th>Total Fraternidades</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php  
            if(isset($infoParaVer["datos"]['bailarines']) && is_array($infoParaVer["datos"]['bailarines'])):
                foreach($infoParaVer["datos"]['bailarines'] as $bailarin): ?>
                    <tr>
                        <td><?php echo $bailarin['ci_bailarin']; ?></td>
                        <td><?php echo htmlspecialchars($bailarin['nombre']); ?></td>
                        <td><?php echo $bailarin['fec_nac']; ?></td>
                        <td>
                            <?php if(isset($bailarin['edad'])): ?>
                                <span class="badge"><?php echo $bailarin['edad']; ?> años</span>
                            <?php else: ?>
                                <span class="badge">N/A</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($bailarin['fraternidades'])): ?>
                                <?php echo htmlspecialchars($bailarin['fraternidades']); ?>
                            <?php else: ?>
                                <span class="badge">Sin fraternidades</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge"><?php echo $bailarin['total_fraternidades'] ?? 0; ?></span>
                        </td>
                        <td>
                            <a href="index.php?controller=bailarinController&funcion=detalle&ci=<?php echo $bailarin['ci_bailarin']; ?>" class="btn btn-info">Ver</a>
                            <a href="index.php?controller=bailarinController&funcion=editar&ci=<?php echo $bailarin['ci_bailarin']; ?>" class="btn btn-primary">Editar</a>
                            <a href="index.php?controller=bailarinController&funcion=eliminar&ci=<?php echo $bailarin['ci_bailarin']; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este bailarín? Se eliminarán todas sus asignaciones a fraternidades.')">Eliminar</a>
                        </td>
                    </tr>
            <?php endforeach; 
            else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay bailarines registrados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>