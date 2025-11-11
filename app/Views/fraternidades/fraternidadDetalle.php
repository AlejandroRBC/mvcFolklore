<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Fraternidad</title>
    <style>
        .card { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #007bff; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 5px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .btn-warning { background-color: #ffc107; color: black; }
        .btn-info { background-color: #17a2b8; color: white; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .info-item { background: white; padding: 15px; border-radius: 5px; border: 1px solid #dee2e6; }
        .badge { background-color: #007bff; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .section-title { margin-top: 30px; margin-bottom: 15px; color: #333; border-bottom: 2px solid #007bff; padding-bottom: 5px; }
    </style>
</head>
<body>
    <h2>Detalle de la Fraternidad</h2>
    
    <?php if(isset($infoParaVer['datos']['error'])): ?>
        <div class="card" style="border-left-color: #dc3545;">
            <h3>Error</h3>
            <p><?php echo $infoParaVer['datos']['error']; ?></p>
            <a href="index.php?controller=fraternidadController&funcion=listar" class="btn btn-secondary">Volver al Listado</a>
        </div>
    <?php else: ?>
    
    <div class="card">
        <div class="info-grid">
            <div class="info-item">
                <strong>ID:</strong><br>
                <?php echo $infoParaVer['datos']['fraternidad']['id_fraternidad']; ?>
            </div>
            <div class="info-item">
                <strong>Nombre:</strong><br>
                <?php echo htmlspecialchars($infoParaVer['datos']['fraternidad']['nombre']); ?>
            </div>
            <div class="info-item">
                <strong>Fecha de Creación:</strong><br>
                <?php echo $infoParaVer['datos']['fraternidad']['fecha_creacion']; ?>
            </div>
            <div class="info-item">
                <strong>Baile:</strong><br>
                <?php if(!empty($infoParaVer['datos']['fraternidad']['nombre_baile'])): ?>
                    <?php echo htmlspecialchars($infoParaVer['datos']['fraternidad']['nombre_baile']); ?>
                <?php else: ?>
                    <span class="badge">Sin baile asignado</span>
                <?php endif; ?>
            </div>
        </div>
        
        <div style="margin-top: 20px;">
            <?php if(isset($_SESSION['logged_in'])): ?>
                <a href="index.php?controller=puntuacionController&funcion=puntuar&id=<?php echo $infoParaVer['datos']['fraternidad']['id_fraternidad']; ?>" class="btn btn-warning">Puntuar esta Fraternidad</a>
            <?php else: ?>
                <a href="index.php?controller=authController&funcion=login" class="btn btn-warning">Inicia sesión para puntuar</a>
            <?php endif; ?>
            <a href="index.php?controller=puntuacionController&funcion=verPuntuaciones&id=<?php echo $infoParaVer['datos']['fraternidad']['id_fraternidad']; ?>" class="btn btn-info">Ver Puntuaciones</a>
            <a href="index.php?controller=fraternidadController&funcion=editar&id=<?php echo $infoParaVer['datos']['fraternidad']['id_fraternidad']; ?>" class="btn btn-primary">Editar</a>
            <a href="index.php?controller=fraternidadController&funcion=listar" class="btn btn-secondary">Volver al Listado</a>
        </div>
    </div>

    <div class="card">
        <h3 class="section-title">Bailarines de la Fraternidad</h3>
        <?php if(isset($infoParaVer['datos']['bailarines']) && !empty($infoParaVer['datos']['bailarines'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Fecha de Nacimiento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($infoParaVer['datos']['bailarines'] as $bailarin): ?>
                        <tr>
                            <td><?php echo $bailarin['ci_bailarin']; ?></td>
                            <td><?php echo htmlspecialchars($bailarin['nombre']); ?></td>
                            <td><?php echo $bailarin['fec_nac']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay bailarines en esta fraternidad.</p>
            <a href="index.php?controller=fraternidadController&funcion=gestionarBailarines&id=<?php echo $infoParaVer['datos']['fraternidad']['id_fraternidad']; ?>" class="btn btn-primary">Agregar Bailarines</a>
        <?php endif; ?>
    </div>

    <?php endif; ?>
</body>
</html>