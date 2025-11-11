<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 2px; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .badge { background-color: #6c757d; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
        .stars { color: #ffc107; }
        .profile-header { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .comentario { background: #f8f9fa; padding: 10px; border-radius: 4px; margin-top: 5px; font-style: italic; }
    </style>
</head>
<body>
    <h2>Mi Perfil</h2>
    
    <?php if(isset($infoParaVer['datos']['usuario'])): ?>
        <div class="profile-header">
            <h3>Información Personal</h3>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($infoParaVer['datos']['usuario']['nombre'] . ' ' . $infoParaVer['datos']['usuario']['apellido']); ?></p>
            <p><strong>Username:</strong> @<?php echo htmlspecialchars($infoParaVer['datos']['usuario']['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($infoParaVer['datos']['usuario']['email']); ?></p>
            <p><strong>Fecha de registro:</strong> <?php echo date('d/m/Y', strtotime($infoParaVer['datos']['usuario']['fecha_registro'])); ?></p>
        </div>
    <?php endif; ?>

    <h3>Mis Puntuaciones</h3>
    
    <?php if(isset($infoParaVer["datos"]['puntuaciones']) && is_array($infoParaVer["datos"]['puntuaciones']) && !empty($infoParaVer["datos"]['puntuaciones'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Fraternidad</th>
                    <th>Baile</th>
                    <th>Mi Puntuación</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($infoParaVer["datos"]['puntuaciones'] as $puntuacion): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($puntuacion['fraternidad_nombre']); ?></strong>
                        </td>
                        <td>
                            <?php if(!empty($puntuacion['baile_nombre'])): ?>
                                <?php echo htmlspecialchars($puntuacion['baile_nombre']); ?>
                            <?php else: ?>
                                <span class="badge">Sin baile</span>
                            <?php endif; ?>
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
                        <td>
                            <a href="index.php?controller=puntuacionController&funcion=puntuar&id=<?php echo $puntuacion['id_fraternidad']; ?>" class="btn btn-secondary">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="text-align: center; padding: 40px; color: #6c757d;">
            <h3>Aún no has puntuado ninguna fraternidad</h3>
            <p>Comienza a explorar las fraternidades y comparte tus opiniones.</p>
            <a href="index.php?controller=fraternidadController&funcion=listar" class="btn btn-secondary">Ver Fraternidades</a>
        </div>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <a href="index.php" class="btn btn-secondary">← Volver al Inicio</a>
    </div>
</body>
</html>