<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bailes</title>
</head>
<body>
    <h2>Bailes</h2>
    <table>
        <thead>
            <tr>
                <td>Nombre</td>
                <td>zona</td>
            </tr>
        </thead>
        <tbody>
        <?php  
            if(isset($infoParaVer["datos"]) && is_array($infoParaVer["datos"])):
                foreach($infoParaVer["datos"] as $baile): ?>
                    <tr>
                        <td><?php echo $baile['nombre']; ?></td>
                        <td><?php echo $baile['zona']; ?></td>
                        <td><?php echo $baile['url_img']; ?></td>
                    </tr>
            <?php endforeach; 
            endif; ?>
        </tbody>
    </table>

</body>
</html>