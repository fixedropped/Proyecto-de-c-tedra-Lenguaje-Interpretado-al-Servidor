<?php
session_start();
require_once "../models/Caso.php";

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['data']['id_rol'] != 1) {
    header("Location: login.php");
    exit();
}

$modelo = new Caso();
$id_caso = $_GET['id'] ?? 0;
$caso = $modelo->obtenerCasoPorId($id_caso);

if (!$caso) { die("Caso no encontrado."); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_estado = $_POST['estado'];
    if ($modelo->actualizarEstado($id_caso, $nuevo_estado)) {
        header("Location: admin_casos.php?msg=estado_actualizado");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Estado - Admin</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
<div class="header"><h1>🔄 Cambiar Estado: Caso #<?php echo $id_caso; ?></h1></div>
<div class="container" style="max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
    <h3>Caso: <?php echo htmlspecialchars($caso['titulo']); ?></h3>
    <p>Estado actual: <strong><?php echo htmlspecialchars($caso['estado'] ?? 'Solicitado'); ?></strong></p>
    
    <form action="" method="POST" style="margin-top: 20px;">
        <label>Seleccione el nuevo estado:</label>
        <select name="estado" style="width: 100%; padding: 10px; margin: 15px 0; border-radius: 5px;">
            <option value="Solicitado" <?php echo ($caso['estado'] == 'Solicitado') ? 'selected' : ''; ?>>Solicitado</option>
            <option value="En proceso" <?php echo ($caso['estado'] == 'En proceso') ? 'selected' : ''; ?>>En proceso</option>
            <option value="Esperando documentación" <?php echo ($caso['estado'] == 'Esperando documentación') ? 'selected' : ''; ?>>Esperando documentación</option>
            <option value="En revisión legal" <?php echo ($caso['estado'] == 'En revisión legal') ? 'selected' : ''; ?>>En revisión legal</option>
            <option value="Finalizado" <?php echo ($caso['estado'] == 'Finalizado') ? 'selected' : ''; ?>>Finalizado</option>
        </select>
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="flex: 1; background: #3498db; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-weight: bold;">Actualizar Estado</button>
            <a href="admin_casos.php" style="flex: 1; text-align: center; background: #95a5a6; color: white; text-decoration: none; padding: 12px; border-radius: 5px; font-weight: bold;">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>