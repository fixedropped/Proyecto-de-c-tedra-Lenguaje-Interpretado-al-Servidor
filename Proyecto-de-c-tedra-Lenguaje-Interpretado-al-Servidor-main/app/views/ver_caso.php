<?php
session_start();
require_once "../models/Caso.php";

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario']['data'];
$id_usuario = $usuario['id_usuario'];
$id_caso = $_GET['id'] ?? 0;

$modelo = new Caso();

// Obtener caso verificando que pertenezca al cliente
$caso = $modelo->obtenerCasoPorId($id_caso, $id_usuario);

// Si no existe o no pertenece al cliente
if (!$caso) {
    header("Location: casos.php?error=no_acceso");
    exit();
}

// Obtener costos del caso
$costos = $modelo->obtenerCostosPorCaso($id_caso);
$total_costos = array_sum(array_column($costos, 'monto'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Caso - CC Asociados</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<div class="header">
    <h1>📄 Detalle del Caso #<?php echo $caso['id_caso']; ?></h1>
</div>

<div class="menu">
    <a href="quienes_somos.php" class="boton">QUIÉNES SOMOS</a>
    <a href="servicios.php" class="boton">SERVICIOS</a>
    <a href="buzon.php" class="boton">BUZÓN</a>
    <a href="casos.php" class="boton">CASOS ACTUALES</a>
    <a href="../../app/controllers/AuthController.php?logout=1" class="boton">CERRAR SESIÓN</a>
</div>

<div style="display: flex; gap: 30px; max-width: 1200px; margin: 40px auto; padding: 0 20px; flex-wrap: wrap;">

    <!-- COLUMNA IZQUIERDA: INFORMACIÓN DEL CASO -->
    <div style="flex: 1; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h2 style="color: #2e86c1; margin-bottom: 20px;"><?php echo htmlspecialchars($caso['titulo']); ?></h2>
        
        <p><strong>📅 Fecha de inicio:</strong> <?php echo $caso['fecha_inicio']; ?></p>
        
        <?php if($caso['fecha_cierre']): ?>
            <p><strong>✅ Fecha de cierre:</strong> <?php echo $caso['fecha_cierre']; ?></p>
        <?php else: ?>
            <p><strong>⏳ Estado:</strong> En proceso</p>
        <?php endif; ?>
        
        <p><strong>⚖️ Servicio:</strong> <?php echo htmlspecialchars($caso['servicio'] ?? 'No especificado'); ?></p>
        <p><strong>👨‍⚖️ Socio encargado:</strong> <?php echo htmlspecialchars($caso['socio'] ?? 'Por asignar'); ?></p>
        <p><strong>📌 Estado actual:</strong> <?php echo htmlspecialchars($caso['estado'] ?? 'En trámite'); ?></p>
        
        <?php if($caso['descripcion']): ?>
            <p><strong>📝 Descripción:</strong></p>
            <p style="background: #f8fbff; padding: 15px; border-radius: 10px;"><?php echo nl2br(htmlspecialchars($caso['descripcion'])); ?></p>
        <?php endif; ?>
    </div>

    <!-- COLUMNA DERECHA: FACTURA / COSTOS -->
    <div style="flex: 1; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h2 style="color: #27ae60; margin-bottom: 20px;">💰 Factura / Costos</h2>
        
        <?php if(empty($costos)): ?>
            <div class="alerta-info" style="background:#fff3cd; color:#856404; padding:15px; border-radius:10px;">
                📌 Aún no hay costos registrados para este caso.
            </div>
        <?php else: ?>
            <table style="width: 100%;">
                <thead>
                    <tr style="background: #2ecc71; color: white;">
                        <th style="padding: 10px;">Concepto</th>
                        <th style="padding: 10px;">Monto</th>
                        <th style="padding: 10px;">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($costos as $costo): ?>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 10px;"><?php echo htmlspecialchars($costo['concepto']); ?></td>
                        <td style="padding: 10px;">$<?php echo number_format($costo['monto'], 2); ?></td>
                        <td style="padding: 10px;"><?php echo $costo['fecha']; ?></td>
                    </tr>
                <?php endforeach; ?>
                    <tr style="background: #f0f0f0; font-weight: bold;">
                        <td style="padding: 10px;">TOTAL</td>
                        <td style="padding: 10px;">$<?php echo number_format($total_costos, 2); ?></td>
                        <td style="padding: 10px;"></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Botón para subir documentos mantiene -->
        <div style="margin-top: 30px; border-top: 2px solid #ddd; padding-top: 20px;">
            <h3>📎 Subir documento</h3>
            <form action="../controllers/subir_archivo.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_caso" value="<?php echo $id_caso; ?>">
                <input type="file" name="archivo" accept=".pdf,.doc,.docx" required style="margin: 10px 0;">
                <button type="submit" style="background:#5dade2; color:white; border:none; padding:10px 20px; border-radius:8px;">Subir archivo</button>
            </form>
        </div>
    </div>

</div>

<div style="text-align: center; margin: 30px;">
    <a href="casos.php" class="boton-volver" style="display: inline-block;">← Volver a mis casos</a>
</div>

</body>
</html>