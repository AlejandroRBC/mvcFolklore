<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Departamento</title>
    <style>
        .card { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #007bff; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 5px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .btn-warning { background-color: #ffc107; color: black; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .info-item { background: white; padding: 15px; border-radius: 5px; border: 1px solid #dee2e6; }
        .badge { background-color: #007bff; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
        .region-badge { 
            background-color: #28a745; 
            color: white; 
            padding: 5px 12px; 
            border-radius: 15px; 
            font-size: 14px; 
            text-transform: uppercase;
            font-weight: bold;
        }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Detalle del Departamento</h2>
    
    <div class="card">
        <div class="info-grid">
            <div class="info-item">
                <strong>ID:</strong><br>
                <?php echo $infoParaVer['datos']['departamento']['id_departamento']; ?>
            </div>
            <div class="info-item">
                <strong>Nombre:</strong><br>
                <?php echo htmlspecialchars($infoParaVer['datos']['departamento']['nombre']); ?>
            </div>
            <div class="info-item">
                <strong>Región:</strong><br>
                <?php if(!empty($infoParaVer['datos']['departamento']['region'])): ?>
                    <span class="region-badge"><?php echo htmlspecialchars($infoParaVer['datos']['departamento']['region']); ?></span>
                <?php else: ?>
                    <span class="badge">No especificada</span>
                <?php endif; ?>
            </div>
        </div>
        
        <div style="margin-top: 20px;">
            <a href="index.php?controller=departamentoController&funcion=editar&id=<?php echo $infoParaVer['datos']['departamento']['id_departamento']; ?>" class="btn btn-primary">Editar</a>
            <a href="index.php?controller=departamentoController&funcion=gestionarBailes&id=<?php echo $infoParaVer['datos']['departamento']['id_departamento']; ?>" class="btn btn-warning">Gestionar Bailes</a>
            <a href="index.php?controller=departamentoController&funcion=listar" class="btn btn-secondary">Volver al Listado</a>
        </div>
    </div>
    
    <div class="card">
        <h3>Bailes Típicos del Departamento</h3>
        <?php if(isset($infoParaVer['datos']['bailes']) && !empty($infoParaVer['datos']['bailes'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ritmo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($infoParaVer['datos']['bailes'] as $baile): ?>
                        <tr>
                            <td><?php echo $baile['id_baile']; ?></td>
                            <td><?php echo htmlspecialchars($baile['nombre']); ?></td>
                            <td>
                                <?php if(!empty($baile['ritmo'])): ?>
                                    <span class="badge"><?php echo htmlspecialchars($baile['ritmo']); ?></span>
                                <?php else: ?>
                                    <span class="badge">No especificado</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>El departamento no tiene bailes asignados.</p>
        <?php endif; ?>
    </div>
</body>
</html>