<?php
session_start();
require_once "../models/Servicio.php";
require_once "../models/Caso.php";

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario']['data'];
$id_usuario = $usuario['id_usuario'];
$id_servicio = $_GET['id'] ?? 0;

if ($id_servicio == 0) {
    header("Location: servicios.php");
    exit();
}

$servicioModel = new Servicio();
$servicio = $servicioModel->obtenerServicioPorId($id_servicio);

if (!$servicio) {
    header("Location: servicios.php?error=servicio_no_encontrado");
    exit();
}

$errores = [];
$exito = false;

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_actual = date('Y-m-d');
    
    // Validaciones
    if (empty($titulo)) {
        $errores[] = "El título es obligatorio";
    }
    
    if (empty($descripcion)) {
        $errores[] = "La descripción es obligatoria";
    }
    
    if (empty($fecha_inicio)) {
        $errores[] = "La fecha de inicio es obligatoria";
    } elseif ($fecha_inicio < $fecha_actual) {
        $errores[] = "La fecha de inicio no puede ser anterior a la fecha actual";
    }
    
    // Validar título (solo letras, números, espacios y caracteres básicos)
    if (!empty($titulo) && !preg_match('/^[a-zA-Z0-9áéíóúñÑÁÉÍÓÚ\s\.,\-]{3,200}$/', $titulo)) {
        $errores[] = "El título solo puede contener letras, números, espacios, puntos y guiones";
    }
    
    // Si no hay errores, guardar el caso
    if (empty($errores)) {
        
        // Obtener un socio aleatorio (o el primero disponible)
        // TODO: En un sistema real, se asignaría un socio específico
        $conexion = (new Database())->conectar();
        $stmt = $conexion->prepare("SELECT id_usuario FROM usuario WHERE id_rol = 1 LIMIT 1");
        $stmt->execute();
        $socio = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_socio = $socio ? $socio['id_usuario'] : 1;
        
        // Insertar el caso
        $sql = "INSERT INTO caso (titulo, descripcion, fecha_inicio, id_cliente, id_socio, id_servicio) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$titulo, $descripcion, $fecha_inicio, $id_usuario, $id_socio, $id_servicio]);
        
        $id_caso = $conexion->lastInsertId();
        
        // Insertar el primer estado del caso
        $sql_estado = "INSERT INTO estado_caso (id_caso, estado, fecha, comentario) 
                       VALUES (?, 'Solicitado', NOW(), 'Caso solicitado por el cliente')";
        $stmt_estado = $conexion->prepare($sql_estado);
        $stmt_estado->execute([$id_caso]);
        
        $exito = true;
        
        // Redirigir después de 2 segundos
        header("refresh:2; url=casos.php");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Servicio - CC Asociados</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
        .solicitud-container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            border: 2px solid #5dade2;
        }
        .solicitud-container h2 {
            color: #2e86c1;
            margin-bottom: 10px;
        }
        .servicio-info {
            background: #eaf6ff;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .campo {
            margin-bottom: 20px;
        }
        .campo label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        .campo input, .campo textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }
        .campo textarea {
            resize: vertical;
            min-height: 100px;
        }
        .btn-enviar {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 14px 25px;
            border-radius: 10px;
            font-size: 1.1rem;
            cursor: pointer;
            width: 100%;
        }
        .btn-enviar:hover {
            background: #27ae60;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .exito {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .volver {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>📝 Solicitar Servicio Legal</h1>
    <p>Complete el formulario para iniciar su caso</p>
</div>

<div class="menu">
    <a href="quienes_somos.php" class="boton">QUIÉNES SOMOS</a>
    <a href="servicios.php" class="boton">SERVICIOS</a>
    <a href="buzon.php" class="boton">BUZÓN</a>
    <a href="casos.php" class="boton">CASOS ACTUALES</a>
    <a href="../../app/controllers/AuthController.php?logout=1" class="boton">CERRAR SESIÓN</a>
</div>

<div class="solicitud-container">

    <?php if($exito): ?>
        <div class="exito">
            ✅ ¡Solicitud enviada con éxito!<br>
            Su caso ha sido registrado. Será redirigido a "Mis Casos" en unos segundos...
        </div>
        <div class="volver">
            <a href="casos.php" class="boton-secundario">Ir ahora a Mis Casos</a>
        </div>
    <?php else: ?>

        <h2>Solicitar: <?php echo htmlspecialchars($servicio['nombre']); ?></h2>
        
        <div class="servicio-info">
            <strong>📋 Descripción del servicio:</strong><br>
            <?php echo htmlspecialchars($servicio['descripcion'] ?? 'Descripción no disponible'); ?>
        </div>

        <?php if(!empty($errores)): ?>
            <?php foreach($errores as $error): ?>
                <div class="error">❌ <?php echo $error; ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="campo">
                <label>Título del caso *</label>
                <input type="text" name="titulo" placeholder="Ej: Problema de herencia familiar" required>
            </div>

            <div class="campo">
                <label>Descripción del problema *</label>
                <textarea name="descripcion" placeholder="Describa detalladamente su situación legal..." required></textarea>
            </div>

            <div class="campo">
                <label>Fecha de inicio *</label>
                <input type="date" name="fecha_inicio" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <button type="submit" class="btn-enviar">📤 Enviar solicitud</button>
        </form>

        <div class="volver">
            <a href="servicios.php" class="boton-volver" style="display: inline-block;">← Volver a servicios</a>
        </div>

    <?php endif; ?>

</div>

</body>
</html>