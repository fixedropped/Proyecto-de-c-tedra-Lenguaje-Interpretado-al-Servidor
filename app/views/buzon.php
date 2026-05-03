<?php
// Simulación para prueba
$id_usuario = 1;
$correo = "cliente@email.com";

// para cuando se creen las sesiones de usuario y
//session_start();
//$id_usuario = $_SESSION['id_usuario'];
//$correo = $_SESSION['email'];

$mensaje = $_GET['msg'] ?? "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buzón</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<!-- HEADER -->
<div class="header">
    <h1>Servicios Legales CC Asociados</h1>
    <p>Buzón de sugerencias</p>
</div>

<!-- MENÚ -->
<div class="menu">
    <a href="quienes_somos.php" class="boton">QUIÉNES SOMOS</a>
    <a href="servicios.php" class="boton">SERVICIOS</a>
    <a href="buzon.php" class="boton">BUZÓN</a>
    <a href="casos.php" class="boton">CASOS ACTUALES</a>
    <a href="login.php" class="boton">INICIAR SESIÓN</a>
    <a href="../../public/index.php" class="boton">VOLVER</a>
</div>

<!-- FORMULARIO -->
<div class="buzon-container">

    <h2>Enviar sugerencia</h2>

    <form method="POST" action="../controllers/procesar_mensaje.php">

        <label>Correo:</label>
        <input type="text" value="<?php echo $correo; ?>" readonly>

        <label>Asunto:</label>
        <input type="text" name="asunto" required>

        <label>Mensaje:</label>
        <textarea name="contenido" required></textarea>

        <button type="submit">Enviar sugerencia</button>

        <div style="text-align:center; margin-top:20px;">
    <a href="mensajes.php" class="boton-secundario">
        Ver Sugerencias
    </a>
</div>

    </form>

</div>


<?php if($mensaje == "ok"): ?>
<script>
    alert(" Sugerencia enviada correctamente");
</script>
<?php elseif($mensaje == "error"): ?>
<script>
    alert(" Error al enviar la sugerencia");
</script>
<?php endif; ?>

</body>

<!-- FOOTER -->
<footer>
    <p>© 2026 CC & Asociados - Todos los derechos reservados</p>
</footer>
</html>