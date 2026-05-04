<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - CC Asociados</title>
    <link rel="stylesheet" href="../../public/css/login.css">
</head>
<body>

<div class="login-container">

    <h2>Iniciar Sesión</h2>

    <?php if(isset($_GET['error'])): ?>
        <?php if($_GET['error'] == 'campos_vacios'): ?>
            <div class="alerta-error">❌ Complete todos los campos</div>
        <?php elseif($_GET['error'] == 'email_invalido'): ?>
            <div class="alerta-error">❌ El formato del correo no es válido</div>
        <?php elseif($_GET['error'] == 'credenciales'): ?>
            <div class="alerta-error">❌ Correo o contraseña incorrectos</div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(isset($_GET['registro']) && $_GET['registro'] == 'ok'): ?>
        <div class="alerta-exito">✅ Registro exitoso. Ahora puede iniciar sesión</div>
    <?php endif; ?>

    <form method="POST" action="../../app/controllers/AuthController.php">
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit" name="login">Ingresar</button>
    </form>

    <hr>

    <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>

    <a href="../../index.php" class="boton-volver">VOLVER AL INICIO</a>
</div>

<script src="../../public/js/login.js"></script>

</body>
</html>