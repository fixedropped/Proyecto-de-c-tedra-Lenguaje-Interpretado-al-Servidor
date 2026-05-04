<?php
session_start();
require_once "../models/Caso.php";

// 1. Verificación de seguridad
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['data']['id_rol'] != 1) {
    header("Location: ../views/login.php"); // Salimos a views para el login
    exit();
}

$modelo = new Caso();
$id_caso = isset($_GET['id']) ? intval($_GET['id']) : 0;
$caso = $modelo->obtenerCasoPorId($id_caso);

if (!$caso) {
    header("Location: ../views/admin_casos.php"); // Salimos a views
    exit();
}

// 2. Lógica de Eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmar'])) {
    
    if ($modelo->eliminarCaso($id_caso)) {
        /* 
           ESTA ES LA CLAVE:
           Como este archivo está en 'controllers', 
           usamos '../views/' para subir un nivel y entrar a la carpeta de vistas.
        */
        header("Location: ../views/admin_casos.php?msg=eliminado");
        exit();
    } else {
        $error_db = "No se pudo eliminar el registro.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Caso - CC Asociados</title>
    <!-- Ajustamos la ruta del CSS también porque estamos en controllers -->
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<div class="header">
    <h1>⚠️ Confirmar Eliminación</h1>
</div>

<div class="container" style="max-width: 500px; margin: 60px auto;">
    <div class="card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.15); text-align: center;">
        <h2 style="color: #e74c3c;">¿Deseas eliminarlo?</h2>
        <p>Se borrará el caso: <strong><?php echo htmlspecialchars($caso['titulo']); ?></strong></p>
        
        <!-- Action vacío para que procese aquí mismo en el controlador -->
        <form action="" method="POST" style="display: flex; gap: 10px; margin-top: 20px;">
            <a href="../views/admin_casos.php" style="flex: 1; background: #bdc3c7; color: black; text-decoration: none; padding: 12px; border-radius: 6px; font-weight: bold; text-align: center;">
                CANCELAR
            </a>
            <button type="submit" name="confirmar" style="flex: 1; background: #e74c3c; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: bold; cursor: pointer;">
                SÍ, ELIMINAR
            </button>
        </form>
    </div>
</div>

</body>
</html>