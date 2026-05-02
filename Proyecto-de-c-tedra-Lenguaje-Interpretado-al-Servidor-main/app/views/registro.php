<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - CC Asociados</title>
    <link rel="stylesheet" href="../../public/css/login.css">
</head>
<body>

<div class="login-container">

    <h3>Crear Cuenta</h3>

    <?php if(isset($_GET['error_registro'])): ?>
        <?php 
            $error = $_GET['error_registro'];
            if($error == 'nombre_vacio'): ?>
                <div class="alerta-error">❌ El nombre es obligatorio</div>
            <?php elseif($error == 'email_vacio'): ?>
                <div class="alerta-error">❌ El correo es obligatorio</div>
            <?php elseif($error == 'password_vacio'): ?>
                <div class="alerta-error">❌ La contraseña es obligatoria</div>
            <?php elseif($error == 'email_invalido'): ?>
                <div class="alerta-error">❌ El formato del correo no es válido</div>
            <?php elseif($error == 'password_corta'): ?>
                <div class="alerta-error">❌ La contraseña debe tener al menos 6 caracteres</div>
            <?php elseif($error == 'telefono_invalido'): ?>
                <div class="alerta-error">❌ El teléfono debe tener entre 8 y 15 dígitos</div>
            <?php elseif($error == 'nombre_invalido'): ?>
                <div class="alerta-error">❌ El nombre solo puede contener letras y espacios</div>
            <?php elseif($error == 'email_existe'): ?>
                <div class="alerta-error">❌ Este correo ya está registrado</div>
            <?php elseif($error == 'general'): ?>
                <div class="alerta-error">❌ Error al registrar. Intente nuevamente</div>
            <?php endif; ?>
    <?php endif; ?>

    <form method="POST" action="../../app/controllers/AuthController.php">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <!-- 🔥 EL NOMBRE DEL CAMPO DEBE SER "email_reg" -->
        <input type="email" name="email_reg" placeholder="Correo electrónico" required>
        <input type="password" name="password_reg" placeholder="Contraseña (mínimo 6 caracteres)" required>
        <input type="text" name="telefono" placeholder="Teléfono (opcional)">
        <button type="submit" name="registro">Registrarse</button>
    </form>

    <hr>

    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>

    <a href="../../public/index.php" class="boton-volver">VOLVER AL INICIO</a>

</div>

<script src="../../public/js/login.js"></script>

</body>
</html>