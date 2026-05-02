<?php
require_once "../models/Mensaje.php";

$modelo = new Mensaje();
$mensajes = $modelo->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sugerencias</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<div class="header">
    <h1>Sugerencias de Clientes</h1>
</div>

<div class="menu">
    <a href="quienes_somos.php" class="boton">QUIÉNES SOMOS</a>
    <a href="servicios.php" class="boton">SERVICIOS</a>
    <a href="../views/buzon.php" class="boton">BUZÓN</a>
    <a href="casos.php" class="boton">CASOS ACTUALES</a>
    <a href="login.php" class="boton">INICIAR SESIÓN</a>
    <a href="../../public/index.php" class="boton">VOLVER</a>
</div>

<div class="tabla-container">

    <h2>Lista de Sugerencias</h2>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php if(!empty($mensajes)): ?>
            <?php foreach($mensajes as $m): ?>
            <tr>
                <td><?php echo $m['id_mensaje']; ?></td>
                <td><?php echo $m['nombre'] ?? 'Sin usuario'; ?></td>
                <td><?php echo $m['asunto']; ?></td>
                <td><?php echo $m['contenido']; ?></td>
                <td><?php echo $m['fecha_envio']; ?></td>
                <td>
                    <a href="../controllers/eliminar_mensaje.php?id=<?php echo $m['id_mensaje']; ?>" 
                       class="btn-eliminar"
                       onclick="return confirm('¿Eliminar este mensaje?')">
                       Eliminar
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No hay sugerencias registradas</td>
            </tr>
        <?php endif; ?>
        </tbody>

    </table>

</div>

</body>
</html>