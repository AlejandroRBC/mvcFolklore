<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puntuar Fraternidad</title>
    <style>
        .form-container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: vertical; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .stars-rating { font-size: 24px; margin: 10px 0; }
        .star { cursor: pointer; color: #ddd; margin: 0 2px; }
        .star:hover, .star.active { color: #ffc107; }
        .error { color: #dc3545; margin-bottom: 15px; }
        .fraternidad-info { background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Puntuar Fraternidad</h2>
    
    <?php if(isset($infoParaVer['datos']['error'])): ?>
        <div class="error"><?php echo $infoParaVer['datos']['error']; ?></div>
    <?php endif; ?>

    <div class="form-container">
        <?php if(isset($infoParaVer['datos']['fraternidad'])): ?>
            <div class="fraternidad-info">
                <h3><?php echo htmlspecialchars($infoParaVer['datos']['fraternidad']['nombre']); ?></h3>
                <?php if(!empty($infoParaVer['datos']['fraternidad']['nombre_baile'])): ?>
                    <p><strong>Baile:</strong> <?php echo htmlspecialchars($infoParaVer['datos']['fraternidad']['nombre_baile']); ?></p>
                <?php endif; ?>
                
                <?php if(isset($infoParaVer['datos']['promedio']) && $infoParaVer['datos']['promedio']['promedio']): ?>
                    <p><strong>Puntuación promedio:</strong> 
                        <?php echo number_format($infoParaVer['datos']['promedio']['promedio'], 1); ?> 
                        (<?php echo $infoParaVer['datos']['promedio']['total_puntuaciones']; ?> votos)
                    </p>
                <?php endif; ?>
            </div>

            <form method="POST" id="puntuacionForm">
                <div class="form-group">
                    <label>Puntuación (1-5 estrellas):</label>
                    <div class="stars-rating" id="starsContainer">
                        <?php 
                        $puntuacionActual = $infoParaVer['datos']['puntuacion_existente']['puntuacion'] ?? 0;
                        for($i = 1; $i <= 5; $i++): 
                            $active = $i <= $puntuacionActual ? 'active' : '';
                        ?>
                            <span class="star <?php echo $active; ?>" data-value="<?php echo $i; ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="puntuacion" id="puntuacionInput" value="<?php echo $puntuacionActual; ?>" required>
                </div>

                <div class="form-group">
                    <label for="comentario">Comentario (opcional):</label>
                    <textarea name="comentario" id="comentario" rows="4" placeholder="Comparte tu experiencia con esta fraternidad..."><?php echo htmlspecialchars($infoParaVer['datos']['puntuacion_existente']['comentario'] ?? ''); ?></textarea>
                </div>

                <div>
                    <button type="submit" class="btn btn-success">
                        <?php echo isset($infoParaVer['datos']['puntuacion_existente']) ? 'Actualizar Puntuación' : 'Enviar Puntuación'; ?>
                    </button>
                    <a href="index.php?controller=fraternidadController&funcion=detalle&id=<?php echo $infoParaVer['datos']['fraternidad']['id_fraternidad']; ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        <?php else: ?>
            <div class="error">Fraternidad no encontrada.</div>
            <a href="index.php?controller=fraternidadController&funcion=listar" class="btn btn-secondary">Volver al Listado</a>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            const puntuacionInput = document.getElementById('puntuacionInput');
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    puntuacionInput.value = value;
                    
                    // Actualizar visualización de estrellas
                    stars.forEach(s => {
                        if(s.getAttribute('data-value') <= value) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
                
                star.addEventListener('mouseover', function() {
                    const value = this.getAttribute('data-value');
                    stars.forEach(s => {
                        if(s.getAttribute('data-value') <= value) {
                            s.style.color = '#ffc107';
                        } else {
                            s.style.color = '#ddd';
                        }
                    });
                });
                
                star.addEventListener('mouseout', function() {
                    const currentValue = puntuacionInput.value;
                    stars.forEach(s => {
                        if(s.getAttribute('data-value') <= currentValue) {
                            s.style.color = '#ffc107';
                        } else {
                            s.style.color = '#ddd';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>