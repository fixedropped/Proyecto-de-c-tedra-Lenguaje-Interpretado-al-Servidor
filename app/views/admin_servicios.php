<?php
session_start();
require_once "../models/Servicio.php";

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['data']['id_rol'] != 1) {
    header("Location: login.php");
    exit();
}

$servicioModel = new Servicio();
$mensaje = '';
$error = '';

// =============================================
// CREAR SERVICIO
// =============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $id_subcategoria = $_POST['id_subcategoria'];
    
    if (empty($nombre)) {
        $error = "❌ El nombre del servicio es obligatorio";
    } elseif (empty($id_subcategoria)) {
        $error = "❌ Debe seleccionar una subcategoría";
    } else {
        $imagen_ruta = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $archivo = $_FILES['imagen'];
            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $nombre_archivo = time() . '_' . uniqid() . '.' . $extension;
            $ruta_destino = '../../public/img/' . $nombre_archivo;
            
            if (!is_dir('../../public/img')) {
                mkdir('../../public/img', 0777, true);
            }
            
            if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
                $imagen_ruta = 'img/' . $nombre_archivo;
            } else {
                $error = "❌ Error al subir la imagen";
            }
        }
        
        if (empty($error)) {
            if ($servicioModel->crearServicio($nombre, $descripcion, $id_subcategoria, $imagen_ruta)) {
                $mensaje = "✅ Servicio creado exitosamente";
            } else {
                $error = "❌ Error al crear el servicio";
            }
        }
    }
}

// =============================================
// ACTUALIZAR SERVICIO
// =============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $id = $_POST['id_servicio'];
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $id_subcategoria = $_POST['id_subcategoria'];
    
    if (empty($nombre)) {
        $error = "❌ El nombre del servicio es obligatorio";
    } else {
        $imagen_ruta = null;
        $subio_imagen = false;
        
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $archivo = $_FILES['imagen'];
            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $nombre_archivo = time() . '_' . uniqid() . '.' . $extension;
            $ruta_destino = '../../public/img/' . $nombre_archivo;
            
            if (!is_dir('../../public/img')) {
                mkdir('../../public/img', 0777, true);
            }
            
            if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
                $imagen_ruta = 'img/' . $nombre_archivo;
                $subio_imagen = true;
            } else {
                $error = "❌ Error al subir la imagen";
            }
        }
        
        if (empty($error)) {
            $resultado = $servicioModel->actualizarServicio($id, $nombre, $descripcion, $id_subcategoria, $imagen_ruta);
            
            if ($resultado) {
                $mensaje = "✅ Servicio actualizado exitosamente";
                if ($subio_imagen) {
                    $mensaje .= " ✅ Imagen actualizada";
                }
            } else {
                $error = "❌ Error al actualizar el servicio";
            }
        }
    }
}

// =============================================
// ELIMINAR SERVICIO
// =============================================
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    if ($servicioModel->eliminarServicio($id)) {
        $mensaje = "✅ Servicio eliminado exitosamente";
    } else {
        $error = "❌ Error al eliminar el servicio";
    }
}

// Obtener datos
$servicios = $servicioModel->obtenerTodosServiciosCompleto();
$categorias = $servicioModel->obtenerCategorias();
$subcategorias = $servicioModel->obtenerTodasSubcategorias();

// Para el formulario de edición
$servicio_editar = null;
if (isset($_GET['editar'])) {
    $servicio_editar = $servicioModel->obtenerServicioCompletoPorId($_GET['editar']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Servicios - Admin</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 20px;
        }
        .formulario-servicio {
            background: #f8fbff;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 2px solid #5dade2;
        }
        .formulario-servicio h3 {
            color: #2e86c1;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        .campo {
            margin-bottom: 15px;
        }
        .campo label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .campo input, .campo textarea, .campo select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }
        .campo textarea {
            resize: vertical;
            min-height: 80px;
        }
        .btn-guardar {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
        }
        .btn-guardar:hover {
            background: #27ae60;
        }
        .btn-cancelar {
            background: #95a5a6;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #5dade2;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }
        .servicio-imagen-tabla {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }
        .btn-editar {
            background: #f39c12;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
            margin: 2px;
            display: inline-block;
        }
        .btn-eliminar {
            background: #e74c3c;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
            margin: 2px;
            display: inline-block;
        }
        .mensaje-exito {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .mensaje-error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .imagen-actual {
            margin: 10px 0;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 8px;
        }
        .imagen-actual img {
            max-width: 100px;
            max-height: 100px;
        }
        .tabla-wrapper {
            overflow-x: auto;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>⚙️ Gestión Completa de Servicios</h1>
    <p>Crear, editar, eliminar servicios y subir imágenes</p>
</div>

<div class="menu">
    <a href="menu_admin.php" class="boton">MENÚ PRINCIPAL</a>
    <a href="admin_servicios.php" class="boton">SERVICIOS</a>
    <a href="../../app/controllers/AuthController.php?logout=1" class="boton">CERRAR SESIÓN</a>
</div>

<div class="admin-container">

    <?php if($mensaje): ?>
        <div class="mensaje-exito"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    
    <?php if($error): ?>
        <div class="mensaje-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- FORMULARIO PARA CREAR/EDITAR SERVICIO -->
    <div class="formulario-servicio">
        <h3><?php echo $servicio_editar ? '✏️ EDITAR SERVICIO' : '➕ CREAR NUEVO SERVICIO'; ?></h3>
        
        <form method="POST" enctype="multipart/form-data">
            <?php if($servicio_editar): ?>
                <input type="hidden" name="id_servicio" value="<?php echo $servicio_editar['id_servicio']; ?>">
            <?php endif; ?>
            
            <div class="campo">
                <label>Nombre del Servicio *</label>
                <input type="text" name="nombre" required value="<?php echo $servicio_editar ? htmlspecialchars($servicio_editar['nombre']) : ''; ?>">
            </div>
            
            <div class="campo">
                <label>Descripción</label>
                <textarea name="descripcion"><?php echo $servicio_editar ? htmlspecialchars($servicio_editar['descripcion']) : ''; ?></textarea>
            </div>
            
            <div class="campo">
                <label>Categoría</label>
                <select name="id_categoria" id="select_categoria">
                    <option value="">Seleccione una categoría</option>
                    <?php foreach($categorias as $cat): ?>
                        <option value="<?php echo $cat['id_categoria']; ?>" 
                            <?php echo ($servicio_editar && isset($servicio_editar['id_categoria']) && $servicio_editar['id_categoria'] == $cat['id_categoria']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="campo">
                <label>Subcategoría *</label>
                <select name="id_subcategoria" id="select_subcategoria" required>
                    <option value="">Primero seleccione una categoría</option>
                    <?php foreach($subcategorias as $sub): ?>
                        <option value="<?php echo $sub['id_subcategoria']; ?>" data-categoria="<?php echo $sub['id_categoria']; ?>"
                            <?php echo ($servicio_editar && $servicio_editar['id_subcategoria'] == $sub['id_subcategoria']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($sub['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="campo">
                <label>Imagen</label>
                <?php if($servicio_editar && $servicio_editar['imagen']): ?>
                    <div class="imagen-actual">
                        <p>Imagen actual:</p>
                        <img src="../../public/<?php echo $servicio_editar['imagen']; ?>" alt="Imagen actual">
                    </div>
                <?php endif; ?>
                <input type="file" name="imagen" accept="image/*">
                <small style="color:#666;">Seleccione una imagen (JPG, PNG, GIF)</small>
            </div>
            
            <button type="submit" name="<?php echo $servicio_editar ? 'editar' : 'crear'; ?>" class="btn-guardar">
                <?php echo $servicio_editar ? '💾 Actualizar Servicio' : '➕ Crear Servicio'; ?>
            </button>
            
            <?php if($servicio_editar): ?>
                <a href="admin_servicios.php" class="btn-cancelar">Cancelar edición</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- TABLA DE SERVICIOS -->
    <h2>📋 Listado de Servicios</h2>

    <?php if(empty($servicios)): ?>
        <p>No hay servicios registrados.</p>
    <?php else: ?>
        <div class="tabla-wrapper">
            <table border="1">
                <thead>
                    <table>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Subcategoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($servicios as $serv): ?>
                    <tr>
                        <td><?php echo $serv['id_servicio']; ?></td>
                        <td style="text-align:center;">
                            <?php if($serv['imagen']): ?>
                                <img src="../../public/<?php echo $serv['imagen']; ?>" class="servicio-imagen-tabla">
                            <?php else: ?>
                                <span style="color:#999;">Sin imagen</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($serv['nombre']); ?></td>
                        <td><?php echo htmlspecialchars(substr($serv['descripcion'] ?? '', 0, 60)); ?>...</td>
                        <td><?php echo htmlspecialchars($serv['categoria_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($serv['subcategoria_nombre']); ?></td>
                        <td style="white-space: nowrap;">
                            <a href="admin_servicios.php?editar=<?php echo $serv['id_servicio']; ?>" class="btn-editar">✏️ Editar</a>
                            <a href="admin_servicios.php?eliminar=<?php echo $serv['id_servicio']; ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar este servicio?')">🗑️ Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
    const selectCategoria = document.getElementById('select_categoria');
    const selectSubcategoria = document.getElementById('select_subcategoria');
    
    if (selectCategoria && selectSubcategoria) {
        const opcionesSub = selectSubcategoria.querySelectorAll('option');
        
        function filtrarSubcategorias() {
            const categoriaId = selectCategoria.value;
            
            opcionesSub.forEach(option => {
                if (option.value === '') return;
                const dataCategoria = option.getAttribute('data-categoria');
                if (categoriaId === '' || dataCategoria === categoriaId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
        }
        
        selectCategoria.addEventListener('change', filtrarSubcategorias);
        filtrarSubcategorias();
    }
</script>

</body>
</html>