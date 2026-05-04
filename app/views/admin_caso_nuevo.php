<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once "../models/Caso.php";

$modelo = new Caso();
$id_socio_admin = $_SESSION['usuario']['data']['id_usuario'] ?? 1; 
$clientes = $modelo->obtenerClientes();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'] ?? 'Sin titulo';
    $descripcion = $_POST['descripcion'] ?? '';
    $id_cliente = intval($_POST['id_cliente'] ?? 0);
    $id_servicio = intval($_POST['id_servicio'] ?? 0);

    if ($modelo->crearCaso($titulo, $descripcion, $id_cliente, $id_socio_admin, $id_servicio)) {
        header("Location: admin_casos.php?msg=creado");
        exit();
    } else {
        $error = "Error al insertar en la base de datos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Caso - CC Asociados</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body style="background-color: #f0f4f8; font-family: sans-serif;">

<div style="max-width: 650px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #3498db;">📋 Registrar Nuevo Caso</h2>
    
    <form method="POST">
        <label style="font-weight: bold;">Título del Caso:</label>
        <input type="text" name="titulo" required style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px;">

        <label style="font-weight: bold;">Descripción:</label>
        <textarea name="descripcion" style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; height: 80px;"></textarea>

        <div style="display: flex; gap: 15px;">
            <div style="flex: 1;">
                <label style="font-weight: bold;">Email del Cliente:</label>
<select name="id_cliente" required style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px;">
    <option value="">Seleccione un correo</option>
    <?php foreach($clientes as $c): ?>
        <option value="<?php echo $c['id_usuario']; ?>">
            <?php echo htmlspecialchars($c['email']); ?>
        </option>
    <?php endforeach; ?>
</select>
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold;">Servicio:</label>
                <select name="id_servicio" required style="width: 100%; padding: 10px; margin: 10px 0;">
                    <option value="">Seleccione servicio</option>
                    <!-- Todas las opciones según tu catálogo -->
                    <option value="1">Lesiones</option>
                    <option value="2">Redacción de contratos</option>
                    <option value="3">Divorcios</option>
                    <option value="4">Estafas y fraudes</option>
                    <option value="5">Robo y hurto</option>
                </select>
            </div>
        </div>

        <button type="submit" style="width: 100%; background: #2ecc71; color: white; border: none; padding: 15px; border-radius: 5px; cursor: pointer; font-weight: bold; margin-top: 20px; font-size: 16px;">
            ✅ GUARDAR CASO
        </button>
        
        <a href="admin_casos.php" style="display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none;">Cancelar</a>
    </form>
</div>

</body>
</html>