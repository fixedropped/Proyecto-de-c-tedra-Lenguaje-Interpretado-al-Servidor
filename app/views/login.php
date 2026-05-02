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

    <?php if(isset($_GET['error'])): ?>
        <div class="alerta-error">Credenciales incorrectas</div>
    <?php endif; ?>

    <form id="loginForm" method="POST" action="../../app/controllers/AuthController.php">
        <input type="email" name="email" id="email" placeholder="Correo" required>
        <input type="password" name="password" id="password" placeholder="Contraseña" required>


        <button type="submit" name="login">Ingresar</button>
    </form>

    <hr>

    <!-- 🔥 REGISTRO -->
    <h3>Crear Cuenta</h3>

    <form id="registroForm" method="POST" action="../../app/controllers/AuthController.php">

        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="email" name="email_reg" placeholder="Correo" required>
        <input type="password" name="password_reg" placeholder="Contraseña" required>
        <input type="text" name="telefono" placeholder="Teléfono">

        <button type="submit" name="registro">Registrarse</button>
    </form>

    <a href="../public/index.php" class="boton-volver">VOLVER</a>

</div>

<script src="../../public/js/login.js"></script>

</body>
</html>