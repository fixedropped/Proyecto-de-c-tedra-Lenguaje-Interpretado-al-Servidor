<?php
session_start();
require_once "../models/Caso.php";

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario']['data'];
$id_cliente = $usuario['id_usuario'];

$modelo = new Caso();
$casos = $modelo->obtenerCasosPorCliente($id_cliente);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Casos - CC Asociados</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<div class="header">
    <h1>📁 Mis Casos Actuales</h1>
    <p>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?></p>
</div>

<div class="menu">
    <a href="quienes_somos.php" class="boton">QUIÉNES SOMOS</a>
    <a href="servicios.php" class="boton">SERVICIOS</a>
    <a href="buzon.php" class="boton">BUZÓN</a>
    <a href="casos.php" class="boton">CASOS ACTUALES</a>
    <a href="../../app/controllers/AuthController.php?logout=1" class="boton">CERRAR SESIÓN</a>
</div>

<div class="tabla-container">

    <h2>Mis Casos</h2>

    <?php if(empty($casos)): ?>
        <div class="alerta-info" style="background:#e7f3ff; color:#2e86c1; padding:20px; border-radius:10px; text-align:center;">
            📌 No tienes casos registrados aún. 
            <a href="servicios.php">Solicita un servicio</a> para comenzar.
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Ver</th>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($casos as $c): ?>
            <tr>
                <td>
                    <a href="ver_caso.php?id=<?php echo $c['id_caso']; ?>" class="boton-secundario" style="padding:6px 12px; font-size:0.9rem;">
                        Ver
                    </a>
                </td>
                <td><?php echo $c['id_caso']; ?></td>
                <td><?php echo htmlspecialchars($c['titulo']); ?></td>
                <td><?php echo htmlspecialchars($c['servicio'] ?? 'N/A'); ?></td>
                <td><?php echo $c['fecha_inicio']; ?></td>
                <td><?php echo htmlspecialchars($c['estado'] ?? 'En trámite'); ?></td>
                <td>$<?php echo number_format($c['total_costos'] ?? 0, 2); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>