<?php
require_once '../models/Conexion.php';

$conexion = Conexion::conectar();

// traer mensajes + email del usuario
$sql = "SELECT m.id_mensaje, m.asunto, m.contenido, u.email
        FROM mensaje m
        INNER JOIN usuario u ON m.id_usuario = u.id_usuario
        ORDER BY m.fecha_envio DESC";

$stmt = $conexion->query($sql);
$mensajes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comunicación</title>

    <link rel="stylesheet" href="../../public/css/BuzonAdmin.css">
</head>
<body>

<div class="container">

    <h2>Mensajes del Buzón</h2>

    <table>
        <tr>
            <th>Asunto</th>
            <th>Correo</th>
            <th>Mensaje</th>
            <th>Acción</th>
        </tr>

        <?php foreach($mensajes as $msg): ?>
        <tr>
            <td><?= $msg['asunto'] ?></td>
            <td><?= $msg['email'] ?></td>

            <!-- MENSAJE CORTO -->
            <td>
                <?= substr($msg['contenido'], 0, 40) ?>...
            </td>

            <td>
                <button onclick="verMas(<?= $msg['id_mensaje'] ?>)">Ver más...</button>
            </td>
        </tr>

        <!-- FILA OCULTA PARA MENSAJE COMPLETO -->
        <tr id="mensaje-<?= $msg['id_mensaje'] ?>" class="fila-oculta">
            <td colspan="4">
                <?= $msg['contenido'] ?>
            </td>
        </tr>

        <?php endforeach; ?>

    </table>

</div>

<script src="../../public/js/BuzonAdmin.js"></script>

</body>
</html>