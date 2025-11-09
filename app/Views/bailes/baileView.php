<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bailes</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-success { background-color: #28a745; color: white; }
    </style>
</head>
<body>
    <h2>Bailes</h2>
    <a href="index.php?controller=baileController&funcion=crear" class="btn btn-success">Nuevo Baile</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Ritmo</th>
                <th>Departamento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php  
            if(isset($infoParaVer["datos"]['bailes']) && is_array($infoParaVer["datos"]['bailes'])):
                foreach($infoParaVer["datos"]['bailes'] as $baile): ?>
                    <tr>
                        <td><?php echo $baile['id_baile']; ?></td>
                        <td><?php echo $baile['nombre']; ?></td>
                        <td><?php echo $baile['ritmo']; ?></td>
                        <td><?php echo $baile['departamento'] ?? 'Sin asignar'; ?></td>
                        <td>
                            <a href="index.php?controller=baileController&funcion=editar&id=<?php echo $baile['id_baile']; ?>" class="btn btn-primary">Editar</a>
                            <a href="index.php?controller=baileController&funcion=eliminar&id=<?php echo $baile['id_baile']; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro?')">Eliminar</a>
                        </td>
                    </tr>
            <?php endforeach; 
            endif; ?>
        </tbody>
    </table>
</body>
</html>