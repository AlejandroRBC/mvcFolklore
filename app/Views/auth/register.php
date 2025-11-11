<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema Folklore</title>
    <style>
        .register-container { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-primary { background-color: #007bff; color: white; }
        .error { color: #dc3545; margin-bottom: 15px; }
        .success { color: #28a745; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Registrar Usuario</h2>
        
        <?php if(isset($infoParaVer['datos']['error'])): ?>
            <div class="error"><?php echo $infoParaVer['datos']['error']; ?></div>
        <?php endif; ?>
        
        <?php if(isset($infoParaVer['datos']['success'])): ?>
            <div class="success"><?php echo $infoParaVer['datos']['success']; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="form-group">
                <label>Apellido:</label>
                <input type="text" name="apellido" required>
            </div>
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
        
        <p style="margin-top: 15px;">
            ¿Ya tienes cuenta? 
            <a href="index.php?controller=authController&funcion=login">Inicia sesión aquí</a>
        </p>
        <p>
            <a href="index.php">← Volver al inicio</a>
        </p>
    </div>
</body>
</html>