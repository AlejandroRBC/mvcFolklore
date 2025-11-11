<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking de Fraternidades</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 2px; }
        .btn-info { background-color: #17a2b8; color: white; }
        .btn-primary { background-color: #007bff; color: white; }
        .badge { background-color: #6c757d; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
        .ranking-badge { 
            background-color: #ffc107; 
            color: black; 
            padding: 5px 10px; 
            border-radius: 50%; 
            font-weight: bold;
            margin-right: 10px;
        }
        .stars { color: #ffc107; font-size: 18px; }
        .stat-card { background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Ranking de Fraternidades Mejor Puntuadas</h2>
    
    <div class="stat-card">
        <p>Estas son las fraternidades mejor evaluadas por los usuarios del sistema.</p>
        <a href="index.php?controller=fraternidadController&funcion=listar" class="btn btn-info">Ver Todas las Fraternidades</a>
    </div>

    <?php if(isset($infoParaVer["datos"]['fraternidades']) && is_array($infoParaVer["datos"]['fraternidades'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Fraternidad</th>
                    <th>Baile</th>
                    <th>Puntuación Promedio</th>
                    <th>Total de Votos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                $posicion = 1;
                foreach($infoParaVer["datos"]['fraternidades'] as $fraternidad): 
                    $promedio = number_format($fraternidad['promedio_puntuacion'], 1);
                    $totalVotos = $fraternidad['total_puntuaciones'] ?? 0;
                    $estrellas = str_repeat('★', round($promedio)) . str_repeat('☆', 5 - round($promedio));
                ?>
                    <tr>
                        <td>
                            <span class="ranking-badge"><?php echo $posicion; ?></span>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($fraternidad['nombre']); ?></strong>
                        </td>
                        <td>
                            <?php if(!empty($fraternidad['baile_nombre'])): ?>
                                <?php echo htmlspecialchars($fraternidad['baile_nombre']); ?>
                            <?php else: ?>
                                <span class="badge">Sin baile</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="stars" title="<?php echo $promedio; ?> de 5 estrellas">
                                <?php echo $estrellas; ?>
                            </div>
                            <small><?php echo $promedio; ?> / 5</small>
                        </td>
                        <td>
                            <span class="badge"><?php echo $totalVotos; ?> voto(s)</span>
                        </td>
                        <td>
                            <a href="index.php?controller=fraternidadController&funcion=detalle&id=<?php echo $fraternidad['id_fraternidad']; ?>" class="btn btn-info">Ver Detalle</a>
                            <?php if(isset($_SESSION['logged_in'])): ?>
                                <a href="index.php?controller=puntuacionController&funcion=puntuar&id=<?php echo $fraternidad['id_fraternidad']; ?>" class="btn btn-primary">Puntuar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php 
                $posicion++;
                endforeach; 
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="text-align: center; padding: 40px; color: #6c757d;">
            <h3>No hay puntuaciones registradas</h3>
            <p>Aún no hay fraternidades con puntuaciones. Sé el primero en puntuar.</p>
            <a href="index.php?controller=fraternidadController&funcion=listar" class="btn btn-primary">Ver Fraternidades</a>
        </div>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <a href="index.php" class="btn btn-info">← Volver al Inicio</a>
    </div>
</body>
</html>