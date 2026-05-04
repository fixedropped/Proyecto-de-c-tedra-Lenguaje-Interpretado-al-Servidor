<?php
session_start();
require_once "../models/Caso.php";

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['data']['id_rol'] != 1) {
    header("Location: login.php");
    exit();
}

$modelo = new Caso();
$id_caso = $_GET['id'] ?? 0;

// ACCIÓN 1: Actualizar el Costo Base (Monto Fijo)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_base'])) {
    $nuevo_monto_base = $_POST['nuevo_monto_base'];
    $modelo->actualizarCostoBase($id_caso, $nuevo_monto_base);
    header("Location: admin_caso_costo.php?id=$id_caso&msg=base_actualizada");
    exit();
}

// ACCIÓN 2: Agregar un Gasto Adicional
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_costo'])) {
    $concepto = $_POST['concepto'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];
    $modelo->agregarCosto($id_caso, $concepto, $monto, $fecha);
    header("Location: admin_caso_costo.php?id=$id_caso&msg=gasto_agregado");
    exit();
}

$caso = $modelo->obtenerCasoPorId($id_caso);
$costos_adicionales = $modelo->obtenerCostosPorCaso($id_caso);

if (!$caso) { die("Caso no encontrado."); }

$precio_base = $caso['total_costos'] ?? 0;
$suma_adicionales = array_sum(array_column($costos_adicionales, 'monto'));
$total_final = $precio_base + $suma_adicionales;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Precios - CC Asociados</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<div class="header">
    <h1>💸 Gestión Financiera: Caso #<?php echo $id_caso; ?></h1>
</div>

<div class="menu">
    <a href="cotizaciones.php" class="boton">VOLVER A COTIZACIONES</a>
</div>

<div class="container" style="max-width: 900px; margin: 20px auto; padding: 20px;">
    
    <div class="card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; color: #2c3e50;">Detalles del Caso: <?php echo htmlspecialchars($caso['titulo']); ?></h2>
        <p style="text-align: center;">Servicio: <strong><?php echo htmlspecialchars($caso['servicio']); ?></strong></p>
        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
        
        <!-- SECCIÓN DE COSTO BASE EDITABLE -->
        <h3 style="color: #2980b9;">1. Editar Costo Base (Honorarios)</h3>
        <form action="" method="POST" style="background: #fcfcfc; padding: 15px; border: 1px solid #dce4ec; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <span>Monto Fijo por el Servicio:</span>
            <div style="display: flex; gap: 10px; align-items: center;">
                <strong style="font-size: 1.2em;">$</strong>
                <input type="number" step="0.01" name="nuevo_monto_base" value="<?php echo $precio_base; ?>" style="padding: 8px; width: 120px; font-weight: bold; border: 1px solid #ccc; border-radius: 4px;">
                <button type="submit" name="update_base" style="background: #2980b9; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold;">
                    Actualizar Base
                </button>
            </div>
        </form>

        <!-- TABLA DE GASTOS ADICIONALES -->
        <h3 style="color: #27ae60;">2. Gastos Adicionales Registrados</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background: #34495e; color: white;">
                    <th style="padding: 12px; text-align: left;">Concepto</th>
                    <th style="padding: 12px; text-align: center;">Fecha</th>
                    <th style="padding: 12px; text-align: right;">Monto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($costos_adicionales as $ca): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;"><?php echo htmlspecialchars($ca['concepto']); ?></td>
                    <td style="padding: 12px; text-align: center;"><?php echo $ca['fecha']; ?></td>
                    <td style="padding: 12px; text-align: right;">$<?php echo number_format($ca['monto'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
                
                <tr style="background: #ebf5fb; font-size: 1.2em;">
                    <td colspan="2" style="padding: 15px; text-align: right; font-weight: bold;">TOTAL ACUMULADO:</td>
                    <td style="padding: 15px; text-align: right; font-weight: bold; color: #27ae60;">$<?php echo number_format($total_final, 2); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- FORMULARIO PARA AGREGAR NUEVOS COSTOS -->
    <div class="card" style="background: #fff; margin-top: 25px; padding: 20px; border-radius: 12px; border: 1px dashed #27ae60;">
        <h3 style="color: #27ae60; margin-bottom: 15px;">➕ Agregar Nuevo Gasto / Viático</h3>
        <form action="" method="POST" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 2;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.9em;">Concepto:</label>
                <input type="text" name="concepto" required placeholder="Ej: Viáticos, Pago de Aranceles..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            <div style="flex: 1;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.9em;">Monto ($):</label>
                <input type="number" step="0.01" name="monto" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            <div style="flex: 1;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.9em;">Fecha:</label>
                <input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            <button type="submit" name="agregar_costo" style="background: #27ae60; color: white; border: none; padding: 12px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; height: 42px;">
                Guardar Gasto
            </button>
        </form>
    </div>
</div>

</body>
</html>