<?php
session_start();
require_once "../models/Usuario.php";

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['data']['id_rol'] != 1) {
    header("Location: login.php");
    exit();
}

$clientes = Usuario::obtenerTodos();
// Filtrar solo clientes (rol = 2)
$clientes = array_filter($clientes, function($u) {
    return $u->id_rol == 2;
});
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes - Admin</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<div class="header">
    <h1>👥 Clientes Registrados</h1>
</div>

<div class="menu">
    <a href="menu_admin.php" class="boton">MENÚ PRINCIPAL</a>
    <a href="../../app/controllers/AuthController.php?logout=1" class="boton">CERRAR SESIÓN</a>
</div>

<div class="tabla-container">
    <h2>Listado de Clientes</h2>

    <?php if(empty($clientes)): ?>
        <div class="alerta-info">No hay clientes registrados.</div>
    <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($clientes as $c): ?>
                <tr>
                    <td><?php echo $c->id_usuario; ?></td>
                    <td><?php echo htmlspecialchars($c->nombre); ?></td>
                    <td><?php echo htmlspecialchars($c->email); ?></td>
                    <td><?php echo htmlspecialchars($c->telefono ?? 'N/A'); ?></td>
                    <td><?php echo $c->fecha_registro; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>