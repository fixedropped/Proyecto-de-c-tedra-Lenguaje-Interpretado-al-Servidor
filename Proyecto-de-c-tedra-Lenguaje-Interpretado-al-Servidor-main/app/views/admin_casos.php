<?php
session_start();
require_once "../models/Caso.php";

// Verificar si el usuario es admin
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
    <title>Gestión de Casos - Admin</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
        .admin-actions {
            margin: 20px 0;
            text-align: right;
        }
        .btn-nuevo {
            background: #2ecc71;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
        }
        .btn-editar {
            background: #f39c12;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
            margin: 2px;
            display: inline-block;
            font-size: 0.85rem;
        }
        .btn-eliminar {
            background: #e74c3c;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
            margin: 2px;
            display: inline-block;
            font-size: 0.85rem;
        }
        .btn-estado {
            background: #3498db;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
            margin: 2px;
            display: inline-block;
            font-size: 0.85rem;
        }
        .btn-costo {
            background: #9b59b6;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
            margin: 2px;
            display: inline-block;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>🗂️ Gestión de Casos - Administrador</h1>
</div>

<div class="menu">
    <a href="menu_admin.php" class="boton">MENÚ PRINCIPAL</a>
    <a href="admin_casos.php" class="boton">GESTIÓN DE CASOS</a>
    <a href="admin_costos.php" class="boton">COSTOS</a>
    <a href="../../app/controllers/AuthController.php?logout=1" class="boton">CERRAR SESIÓN</a>
</div>

<div class="tabla-container">
    <div class="admin-actions">
        <a href="admin_caso_crear.php" class="btn-nuevo">+ Crear Nuevo Caso</a>
    </div>

    <h2>Listado de Casos</h2>

    <?php if(isset($_GET['msg'])): ?>
        <div class="alerta-exito" style="margin-bottom:20px;">
            <?php 
                if($_GET['msg'] == 'creado') echo "✅ Caso creado exitosamente";
                if($_GET['msg'] == 'actualizado') echo "✅ Caso actualizado exitosamente";
                if($_GET['msg'] == 'eliminado') echo "✅ Caso eliminado exitosamente";
                if($_GET['msg'] == 'costo_agregado') echo "✅ Costo agregado exitosamente";
                if($_GET['msg'] == 'estado_cambiado') echo "✅ Estado cambiado exitosamente";
            ?>
        </div>
    <?php endif; ?>

    <?php if(empty($casos)): ?>
        <div class="alerta-info">No hay casos registrados.</div>
    <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Cliente</th>
                    <th>Servicio</th>
                    <th>Fecha Inicio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($casos as $c): ?>
            <tr>
                <td><?php echo $c['id_caso']; ?></td>
                <td><?php echo htmlspecialchars($c['titulo']); ?></td>
                <td><?php echo htmlspecialchars($c['cliente'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($c['servicio'] ?? 'N/A'); ?></td>
                <td><?php echo $c['fecha_inicio']; ?></td>
                <td><?php echo htmlspecialchars($c['estado'] ?? 'Sin estado'); ?></td>
                <td>
                    <a href="admin_caso_editar.php?id=<?php echo $c['id_caso']; ?>" class="btn-editar">Editar</a>
                    <a href="admin_caso_estado.php?id=<?php echo $c['id_caso']; ?>" class="btn-estado">Cambiar Estado</a>
                    <a href="admin_caso_costo.php?id=<?php echo $c['id_caso']; ?>" class="btn-costo">Agregar Costo</a>
                    <a href="../controllers/admin_caso_eliminar.php?id=<?php echo $c['id_caso']; ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar este caso?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>