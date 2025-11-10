<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Bailarín</title>
    <style>
        .card { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #007bff; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 5px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .info-item { background: white; padding: 15px; border-radius: 5px; border: 1px solid #dee2e6; }
        .badge { background-color: #007bff; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Detalle del Bailarín</h2>
    
    <div class="card">
        <div class="info-grid">
            <div class="info-item">
                <strong>Cédula de Identidad:</strong><br>
                <?php echo $infoParaVer['datos']['bailarin']['ci_bailarin']; ?>
            </div>
            <div class="info-item">
                <strong>Nombre Completo:</strong><br>
                <?php echo htmlspecialchars($infoParaVer['datos']['bailarin']['nombre']); ?>
            </div>
            <div class="info-item">
                <strong>Fecha de Nacimiento:</strong><br>
                <?php echo $infoParaVer['datos']['bailarin']['fec_nac']; ?>
            </div>
            <div class="info-item">
                <strong>Edad:</strong><br>
                <span class="badge"><?php echo $infoParaVer['datos']['bailarin']['edad']; ?> años</span>
            </div>
        </div>
        
        <div style="margin-top: 20px;">
            <a href="index.php?controller=bailarinController&funcion=editar&ci=<?php echo $infoParaVer['datos']['bailarin']['ci_bailarin']; ?>" class="btn btn-primary">Editar</a>
            <a href="index.php?controller=bailarinController&funcion=listar" class="btn btn-secondary">Volver al Listado</a>
        </div>
    </div>
    
    <div class="card">
        <h3>Fraternidades a las que pertenece</h3>
        <?php if(isset($infoParaVer['datos']['fraternidades']) && !empty($infoParaVer['datos']['fraternidades'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha Creación</th>
                        <th>Baile</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($infoParaVer['datos']['fraternidades'] as $fraternidad): ?>
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>El bailarín no pertenece a ninguna fraternidad.</p>
        <?php endif; ?>
    </div>
</body>
</html>