<?php
require_once '../models/Usuario.php';
session_start();

// obtener admins
$admins = array_filter(Usuario::obtenerTodos(), function($u){
    return $u->id_rol == 1;
});
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Socio</title>
    <link rel="stylesheet" href="../../public/css/socio.css">
</head>
<body>

<div class="container">

    <h2>Agregar Nuevo Socio</h2>

    <!-- FORMULARIO -->
    <form method="POST" action="../controllers/SocioController.php">

        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="text" name="telefono" placeholder="Teléfono">

        <!-- rol fijo como admin -->
        <input type="hidden" name="id_rol" value="1">

        <button type="submit" name="crear">Agregar Socio</button>
    </form>

    <h2>Socios Registrados</h2>

    <!-- TABLA -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>

        <?php foreach($admins as $admin): ?>
        <tr>
            <td><?= $admin->id_usuario ?></td>
            <td><?= $admin->nombre ?></td>
            <td><?= $admin->email ?></td>
            <td><?= $admin->telefono ?></td>
            <td>
                <a href="../controllers/SocioController.php?eliminar=<?= $admin->id_usuario ?>" class="btn-eliminar">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>

</body>
</html>