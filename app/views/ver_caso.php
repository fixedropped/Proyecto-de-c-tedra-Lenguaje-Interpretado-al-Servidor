<?php
require_once "../models/Caso.php";

$id = $_GET['id'] ?? 0;

$modelo = new Caso();
$caso = $modelo->obtenerCasoPorId($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Caso</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<div class="header">
    <h1>Detalle del Caso</h1>
</div>

<div class="menu">
     <a href="quienes_somos.php" class="boton">QUIÉNES SOMOS</a>
    <a href="servicios.php" class="boton">SERVICIOS</a>
    <a href="../views/buzon.php" class="boton">BUZÓN</a>
    <a href="casos.php" class="boton">CASOS ACTUALES</a>
    <a href="login.php" class="boton">INICIAR SESIÓN</a>
    <a href="../../public/index.php" class="boton">VOLVER</a>
</div>

<div class="detalle-container">

    <!-- IZQUIERDA -->
    <div class="lado-izq">

        <h3>Documentación a enviar</h3>

        <form action="../controllers/subir_archivo.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_caso" value="<?php echo $id; ?>">

            <input type="file" name="archivo" accept=".pdf,.doc,.docx" required>

            <button type="submit">Subir archivo</button>
        </form>

    </div>

    <!-- DERECHA -->
    <div class="lado-der">

        <h2><?php echo $caso['titulo'] ?? 'Sin título'; ?></h2>

        <p><strong>Estado:</strong> <?php echo $caso['estado'] ?? 'Sin estado'; ?></p>

        <br>

        <button class="boton-secundario">Pedir reporte</button>

        <br><br>

        <p><strong>Socio encargado:</strong></p>
        <p><?php echo $caso['socio'] ?? 'No asignado'; ?></p>

    </div>

</div>

</body>
</html>