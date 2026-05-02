<?php
require_once "../models/Caso.php";

$modelo = new Caso();
$casos = $modelo->obtenerCasos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Casos Actuales</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<div class="header">
    <h1>Casos Actuales</h1>
</div>

<div class="menu">
    <a href="quienes_somos.php" class="boton">QUIÉNES SOMOS</a>
    <a href="servicios.php" class="boton">SERVICIOS</a>
    <a href="buzon.php" class="boton">BUZÓN</a>
    <a href="casos.php" class="boton">CASOS ACTUALES</a>
    <a href="login.php" class="boton">INICIAR SESIÓN</a>
    <a href="../../public/index.php" class="boton">VOLVER</a>
</div>

<div class="tabla-container">

    <h2>Listado de Casos</h2>

    <table>
        <thead>
            <tr>
                <th>Ver</th>
                <th>Código</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Proceso</th>
            </tr>
        </thead>

        <tbody>
        <?php if(!empty($casos)): ?>
            <?php foreach($casos as $c): ?>
            <tr>
                <td>
                    <a href="ver_caso.php?id=<?php echo $c['id_caso']; ?>" class="boton-secundario">
                        Ver
                    </a>
                </td>
                <td><?php echo $c['id_caso']; ?></td>
                <td><?php echo $c['servicio'] ?? 'N/A'; ?></td>
                <td><?php echo $c['fecha_inicio']; ?></td>
                <td><?php echo $c['estado'] ?? 'Sin estado'; ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No hay casos registrados</td>
            </tr>
        <?php endif; ?>
        </tbody>

    </table>

</div>

</body>
</html>