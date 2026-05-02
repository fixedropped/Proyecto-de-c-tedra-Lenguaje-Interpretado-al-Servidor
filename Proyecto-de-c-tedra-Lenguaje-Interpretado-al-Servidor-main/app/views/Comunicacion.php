<?php
session_start();
require_once "../models/Mensaje.php";

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['data']['id_rol'] != 1) {
    header("Location: login.php");
    exit();
}

$modelo = new Mensaje();
$mensajes = $modelo->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comunicación - Admin</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
        .btn-responder {
            background: #2ecc71;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.85rem;
        }
        .mensaje-contenido {
            max-width: 300px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>📬 Comunicación con Clientes</h1>
    <p>Mensajes del buzón de sugerencias</p>
</div>

<div class="menu">
    <a href="menu_admin.php" class="boton">MENÚ PRINCIPAL</a>
    <a href="BuzonAdmin.php" class="boton">VER BUZÓN</a>
    <a href="../../app/controllers/AuthController.php?logout=1" class="boton">CERRAR SESIÓN</a>
</div>

<div class="tabla-container">
    <h2>Mensajes Recibidos</h2>

    <?php if(empty($mensajes)): ?>
        <div class="alerta-info">No hay mensajes en el buzón.</div>
    <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($mensajes as $m): ?>
                <tr>
                    <td><?php echo $m['id_mensaje']; ?></td>
                    <td><?php echo htmlspecialchars($m['nombre'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($m['email'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($m['asunto']); ?></td>
                    <td class="mensaje-contenido"><?php echo nl2br(htmlspecialchars(substr($m['contenido'], 0, 100))); ?>...</td>
                    <td><?php echo $m['fecha_envio']; ?></td>
                    <td>
                        <a href="mailto:<?php echo $m['email']; ?>" class="btn-responder">✉️ Responder</a>
                        <a href="../controllers/eliminar_mensaje.php?id=<?php echo $m['id_mensaje']; ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar este mensaje?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>