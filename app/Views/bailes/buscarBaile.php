<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Bailes</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 2px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-info { background-color: #17a2b8; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .badge { background-color: #6c757d; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
        .ritmo-badge { background-color: #28a745; color: white; padding: 3px 8px; border-radius: 10px; font-size: 10px; text-transform: uppercase; }
        .search-container { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .search-form { display: flex; gap: 10px; align-items: end; }
        .form-group { flex: 1; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { padding: 8px; width: 100%; border: 1px solid #ddd; border-radius: 4px; }
        .results-info { margin: 15px 0; padding: 10px; background: #e9ecef; border-radius: 4px; }
        .no-results { text-align: center; padding: 40px; color: #6c757d; }
    </style>
</head>
<body>
    <h2>Buscar Bailes</h2>
    
    <div class="search-container">
        <form method="GET" class="search-form">
            <input type="hidden" name="controller" value="baileController">
            <input type="hidden" name="funcion" value="buscar">
            
            <div class="form-group">
                <label for="search-term">Buscar por nombre o ritmo:</label>
                <input type="text" id="search-term" name="q" 
                       value="<?php echo htmlspecialchars($infoParaVer['datos']['termino'] ?? ''); ?>" 
                       placeholder="Ej: Caporal, Tinku, Morenada...">
            </div>
            
            <div>
                <button type="submit" class="btn btn-info" style="height: 38px;">Buscar</button>
            </div>
        </form>
        
        <a href="index.php?controller=baileController&funcion=listar" class="btn btn-secondary">Volver al Listado Completo</a>
    </div>

    <?php if(isset($infoParaVer['datos']['termino']) && !empty($infoParaVer['datos']['termino'])): ?>
        <div class="results-info">
            <strong>Resultados de búsqueda para:</strong> "<?php echo htmlspecialchars($infoParaVer['datos']['termino']); ?>"
            <?php if(isset($infoParaVer['datos']['resultados'])): ?>
                <span class="badge"><?php echo count($infoParaVer['datos']['resultados']); ?> resultado(s) encontrado(s)</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if(isset($infoParaVer['datos']['resultados']) && is_array($infoParaVer['datos']['resultados'])): ?>
        <?php if(!empty($infoParaVer['datos']['resultados'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ritmo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($infoParaVer['datos']['resultados'] as $baile): ?>
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
                                <a href="index.php?controller=baileController&funcion=detalle&id=<?php echo $baile['id_baile']; ?>" class="btn btn-info">Ver</a>
                                <a href="index.php?controller=baileController&funcion=editar&id=<?php echo $baile['id_baile']; ?>" class="btn btn-primary">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-results">
                <h3>No se encontraron resultados</h3>
                <p>No hay bailes que coincidan con "<?php echo htmlspecialchars($infoParaVer['datos']['termino']); ?>"</p>
                <p>Intenta con otros términos de búsqueda.</p>
            </div>
        <?php endif; ?>
    <?php elseif(isset($infoParaVer['datos']['termino']) && empty($infoParaVer['datos']['termino'])): ?>
        <div class="no-results">
            <h3>Ingresa un término de búsqueda</h3>
            <p>Por favor, escribe el nombre de un baile o ritmo en el campo de búsqueda.</p>
        </div>
    <?php else: ?>
        <div class="no-results">
            <h3>Búsqueda de Bailes</h3>
            <p>Utiliza el formulario de arriba para buscar bailes por nombre o ritmo.</p>
            <p><strong>Ejemplos:</strong> "Caporal", "Tinku", "Morenada", "Diablada", etc.</p>
        </div>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <a href="index.php?controller=baileController&funcion=listar" class="btn btn-secondary">← Volver al Listado Completo</a>
    </div>
</body>
</html>