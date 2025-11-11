<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puntuaciones de Fraternidad</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 2px; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .badge { background-color: #6c757d; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
        .stars { color: #ffc107; }
        .fraternidad-header { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .comentario { background: #f8f9fa; padding: 10px; border-radius: 4px; margin-top: 5px; font-style: italic; }
    </style>
</head>
<body>
    <h2>Puntuaciones de la Fraternidad</h2>
    
    <?php if(isset($infoParaVer['datos']['fraternidad'])): ?>
        <div class="fraternidad-header">
            <h3><?php echo htmlspecialchars($infoParaVer['datos']['fraternidad']['nombre']); ?></h3>
            <?php if(isset($infoParaVer['datos']['promedio'])): ?>
                <p>
                    <strong>Puntuación promedio:</strong> 
                    <span class="stars">
                        <?php 
                        $promedio = number_format($infoParaVer['datos']['promedio']['promedio'], 1);
                        echo str_repeat('★', round($promedio)) . str_repeat('☆', 5 - round($promedio));
                        ?>
                    </span>
                    (<?php echo $promedio; ?> de 5) - 
                    <span class="badge"><?php echo $infoParaVer['datos']['promedio']['total_puntuaciones']; ?> votos</span>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if(isset($infoParaVer["datos"]['puntuaciones']) && is_array($infoParaVer["datos"]['puntuaciones'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Puntuación</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($infoParaVer["datos"]['puntuaciones'] as $puntuacion): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($puntuacion['nombre'] . ' ' . $puntuacion['apellido']); ?></strong>
                            <br><small>@<?php echo htmlspecialchars($puntuacion['username']); ?></small>
                        </td>
                        <td>
                            <span class="stars">
                                <?php echo str_repeat('★', $puntuacion['puntuacion']) . str_repeat('☆', 5 - $puntuacion['puntuacion']); ?>
                            </span>
                            <br><small><?php echo $puntuacion['puntuacion']; ?> / 5</small>
                        </td>
                        <td>
                            <?php if(!empty($puntuacion['comentario'])): ?>
                                <div class="comentario">"<?php echo htmlspecialchars($puntuacion['comentario']); ?>"</div>
                            <?php else: ?>
                                <span class="badge">Sin comentario</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo date('d/m/Y H:i', strtotime($puntuacion['fecha_puntuacion'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="text-align: center; padding: 40px; color: #6c757d;">
            <h3>No hay puntuaciones registradas</h3>
            <p>Esta fraternidad aún no ha recibido puntuaciones.</p>
        </div>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <a href="index.php?controller=fraternidadController&funcion=detalle&id=<?php echo $infoParaVer['datos']['fraternidad']['id_fraternidad']; ?>" class="btn btn-secondary">← Volver a la Fraternidad</a>
        <a href="index.php?controller=puntuacionController&funcion=ranking" class="btn btn-secondary">Ver Ranking</a>
    </div>
</body>
</html>