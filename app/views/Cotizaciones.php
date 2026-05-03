<?php
session_start();
require_once "../models/Caso.php";

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['data']['id_rol'] != 1) {
    header("Location: login.php");
    exit();
}

$modelo = new Caso();
$casos = $modelo->obtenerTodosLosCasos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotizaciones - Admin</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<div class="header">
    <h1>💰 Cotizaciones / Costos por Caso</h1>
</div>

<div class="menu">
    <a href="menu_admin.php" class="boton">MENÚ PRINCIPAL</a>
    <a href="admin_casos.php" class="boton">GESTIÓN DE CASOS</a>
    <a href="../../app/controllers/AuthController.php?logout=1" class="boton">CERRAR SESIÓN</a>
</div>

<div class="tabla-container">
    <h2>Costos por Caso</h2>

    <?php if(empty($casos)): ?>
        <div class="alerta-info">No hay casos registrados.</div>
    <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID Caso</th>
                    <th>Título</th>
                    <th>Cliente</th>
                    <th>Servicio</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($casos as $c): ?>
                <tr>
                    <td><?php echo $c['id_caso']; ?></td>
                    <td><?php echo htmlspecialchars($c['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($c['cliente'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($c['servicio'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($c['estado'] ?? 'Sin estado'); ?></td>
                    <td>
                        <a href="admin_caso_costo.php?id=<?php echo $c['id_caso']; ?>" class="btn-cotizar">Agregar Costo</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>