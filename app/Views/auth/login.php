<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Folklore</title>
    <style>
        .login-container { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
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
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        
        <?php if(isset($infoParaVer['datos']['error'])): ?>
            <div class="error"><?php echo $infoParaVer['datos']['error']; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
        
        <p style="margin-top: 15px;">
            ¿No tienes cuenta? 
            <a href="index.php?controller=authController&funcion=register">Regístrate aquí</a>
        </p>
        <p>
            <a href="index.php">← Volver al inicio</a>
        </p>
    </div>
</body>
</html>