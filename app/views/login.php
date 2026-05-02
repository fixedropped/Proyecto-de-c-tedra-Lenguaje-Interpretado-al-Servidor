<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="../../public/css/login.css">
</head>
<body>

<div class="login-container">
    <h2>Iniciar Sesión</h2>

    <!-- ERROR -->
    <?php if(isset($_GET['error'])): ?>
        <div class="alerta-error">Correo o contraseña incorrectos</div>
    <?php endif; ?>

    <form id="loginForm" method="POST" action="../../app/controllers/AuthController.php">

        <input type="email" name="email" id="email" placeholder="Correo" required>
        <input type="password" name="password" id="password" placeholder="Contraseña" required>

        <button type="submit">Ingresar</button>

        <a href="../../public/index.php" class="boton-volver">volver</a>
    </form>
</div>

<script src="../../public/js/login.js"></script>

</body>
</html>