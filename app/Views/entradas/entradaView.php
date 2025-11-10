<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entradas</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 5px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-info { background-color: #17a2b8; color: white; }
        .badge { background-color: #6c757d; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
    </style>
</head>
<body>
    <h2>Entradas</h2>
    <a href="index.php?controller=entradaController&funcion=crear" class="btn btn-success">Nueva Entrada</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Gestión</th>
                <th>Fecha</th>
                <th>Fraternidades</th>
                <th>Horarios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php  
            if(isset($infoParaVer["datos"]['entradas']) && is_array($infoParaVer["datos"]['entradas'])):
                foreach($infoParaVer["datos"]['entradas'] as $entrada): ?>
                    <tr>
                        <td><?php echo $entrada['id_entrada']; ?></td>
                        <td><?php echo htmlspecialchars($entrada['nombre']); ?></td>
                        <td><?php echo $entrada['gestion']; ?></td>
                        <td><?php echo $entrada['fecha']; ?></td>
                        <td>
                            <?php if(!empty($entrada['fraternidades'])): ?>
                                <?php echo htmlspecialchars($entrada['fraternidades']); ?>
                            <?php else: ?>
                                <span class="badge">Sin asignar</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($entrada['horarios'])): ?>
                                <?php echo htmlspecialchars($entrada['horarios']); ?>
                            <?php else: ?>
                                <span class="badge">Sin horario</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?controller=entradaController&funcion=editar&id=<?php echo $entrada['id_entrada']; ?>" class="btn btn-primary">Editar</a>
                            <a href="index.php?controller=entradaController&funcion=eliminar&id=<?php echo $entrada['id_entrada']; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar esta entrada?')">Eliminar</a>
                        </td>
                    </tr>
            <?php endforeach; 
            else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay entradas registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>