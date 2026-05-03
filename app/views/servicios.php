<?php
session_start();
require_once '../models/Servicio.php';

$servicioModel = new Servicio();
$categorias = $servicioModel->obtenerCategoriasConServicios();

$usuarioLogueado = isset($_SESSION['usuario']);
$nombreUsuario = $usuarioLogueado ? $_SESSION['usuario']['data']['nombre'] : '';

// Obtener categorías para el carrusel
$categorias_carrusel = [];
foreach($categorias as $cat) {
    $categorias_carrusel[] = [
        'nombre' => $cat['nombre'],
        'descripcion' => $cat['descripcion'],
        'icono' => obtenerIconoCategoria($cat['nombre'])
    ];
}

function obtenerIconoCategoria($nombre) {
    switch($nombre) {
        case 'Derecho Penal':
            return 'https://cdn-icons-png.flaticon.com/512/3135/3135712.png';
        case 'Derecho Civil':
            return 'https://cdn-icons-png.flaticon.com/512/2818/2818128.png';
        case 'Derecho Notarial':
            return 'https://cdn-icons-png.flaticon.com/512/1903/1903273.png';
        case 'Derecho Laboral':
            return 'https://cdn-icons-png.flaticon.com/512/2917/2917657.png';
        default:
            return '../../public/img/default.png';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios Legales - CC Asociados</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
        .servicios-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .categoria-section {
            margin-bottom: 50px;
        }
        .categoria-titulo {
            background: linear-gradient(90deg, #5dade2, #3498db);
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 1.8rem;
        }
        .categoria-descripcion {
            color: #555;
            margin-bottom: 20px;
            font-size: 1rem;
            padding-left: 10px;
        }
        .servicios-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }
        .servicio-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #e0e0e0;
            cursor: pointer;
            text-align: center;
        }
        .servicio-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .servicio-imagen {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px auto;
        }
        .servicio-imagen img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .servicio-nombre {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2e86c1;
            margin-bottom: 12px;
        }
        .servicio-descripcion {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .btn-cotizar {
            display: inline-block;
            background: #5dade2;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.3s;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .btn-cotizar:hover {
            background: #3498db;
        }
        .sin-servicios {
            background: #f0f0f0;
            padding: 20px;
            text-align: center;
            border-radius: 12px;
            color: #888;
        }
        .bienvenida {
            background: #2ecc71;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 1rem;
        }

        /* ========== CARRUSEL ========== */
        .carrusel-container {
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .carrusel-slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .carrusel-slide {
            min-width: 100%;
            background: linear-gradient(135deg, #5dade2, #2e86c1);
            color: white;
            padding: 50px 40px;
            text-align: center;
        }
        .carrusel-icono {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px auto;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }
        .carrusel-icono img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .carrusel-slide h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }
        .carrusel-slide p {
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            opacity: 0.9;
        }
        .carrusel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.3);
            color: white;
            border: none;
            font-size: 2rem;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 50%;
            transition: 0.3s;
            z-index: 10;
        }
        .carrusel-btn:hover {
            background: rgba(255,255,255,0.6);
            color: #2e86c1;
        }
        .carrusel-prev {
            left: 15px;
        }
        .carrusel-next {
            right: 15px;
        }
        .carrusel-dots {
            position: absolute;
            bottom: 15px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            z-index: 10;
        }
        .dot {
            width: 12px;
            height: 12px;
            background: rgba(255,255,255,0.5);
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
        }
        .dot.activo {
            background: white;
            transform: scale(1.2);
        }

        /* ========== PANEL DE DETALLE ========== */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 998;
        }
        .detalle-panel {
            display: none;
            position: fixed;
            right: 0;
            top: 0;
            width: 500px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 30px rgba(0,0,0,0.3);
            z-index: 999;
            overflow-y: auto;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }
        .detalle-header {
            background: linear-gradient(90deg, #5dade2, #3498db);
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
        }
        .detalle-header h3 {
            margin: 0;
            font-size: 1.5rem;
        }
        .btn-cerrar-panel {
            background: none;
            border: none;
            color: white;
            font-size: 32px;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }
        .btn-cerrar-panel:hover {
            opacity: 0.8;
        }
        .detalle-contenido {
            padding: 30px;
            text-align: center;
        }
        .detalle-imagen {
            text-align: center;
            margin-bottom: 30px;
        }
        .detalle-imagen img {
            max-width: 100%;
            max-height: 220px;
            object-fit: contain;
        }
        .detalle-nombre {
            font-size: 2rem;
            font-weight: bold;
            color: #2e86c1;
            margin-bottom: 15px;
        }
        .detalle-categoria {
            background: #eaf4ff;
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            color: #2e86c1;
            margin-bottom: 25px;
            font-size: 1rem;
        }
        .detalle-descripcion {
            text-align: justify;
            line-height: 1.8;
            color: #333;
            margin-bottom: 35px;
            font-size: 1rem;
        }
        .detalle-footer {
            border-top: 1px solid #ddd;
            padding-top: 25px;
        }
        .btn-cotizar-panel {
            background: #2ecc71;
            color: white;
            text-decoration: none;
            padding: 14px 35px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 1.2rem;
            display: inline-block;
            width: 80%;
        }
        .btn-cotizar-panel:hover {
            background: #27ae60;
        }
        @media (max-width: 768px) {
            .detalle-panel {
                width: 100%;
            }
            .carrusel-slide h2 {
                font-size: 1.5rem;
            }
            .carrusel-slide p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>📋 Nuestros Servicios Legales</h1>
    <p>Asesoría especializada para cada necesidad</p>
</div>

<div class="menu">
    <a href="quienes_somos.php" class="boton">QUIÉNES SOMOS</a>
    <a href="servicios.php" class="boton">SERVICIOS</a>
    <a href="buzon.php" class="boton">BUZÓN</a>
    <a href="casos.php" class="boton">CASOS ACTUALES</a>
    <?php if($usuarioLogueado): ?>
        <a href="../../app/controllers/AuthController.php?logout=1" class="boton">CERRAR SESIÓN</a>
    <?php else: ?>
        <a href="login.php" class="boton">INICIAR SESIÓN</a>
    <?php endif; ?>
</div>

<div class="servicios-container">

    <!-- ========== CARRUSEL ========== -->
     
    <?php if($usuarioLogueado): ?>
        <div class="bienvenida">
            👋 ¡Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?>! 
            Haz clic en un servicio para ver su detalle a la derecha.
        </div>
    <?php endif; ?>
    <div class="carrusel-container">
        <div class="carrusel-slides" id="carruselSlides">
            <?php foreach($categorias_carrusel as $index => $cat): ?>
                <div class="carrusel-slide">
                    <div class="carrusel-icono">
                        <img src="<?php echo $cat['icono']; ?>" alt="<?php echo $cat['nombre']; ?>">
                    </div>
                    <h2><?php echo htmlspecialchars($cat['nombre']); ?></h2>
                    <p><?php echo htmlspecialchars($cat['descripcion'] ?? 'Asesoría legal especializada'); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if(count($categorias_carrusel) > 1): ?>
            <button class="carrusel-btn carrusel-prev" onclick="slidePrevio()">❮</button>
            <button class="carrusel-btn carrusel-next" onclick="slideSiguiente()">❯</button>
            <div class="carrusel-dots" id="carruselDots">
                <?php foreach($categorias_carrusel as $index => $cat): ?>
                    <div class="dot <?php echo $index == 0 ? 'activo' : ''; ?>" onclick="irSlide(<?php echo $index; ?>)"></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    

    <?php if(empty($categorias)): ?>
        <div class="sin-servicios">
            <p>No hay servicios disponibles en este momento.</p>
        </div>
    <?php else: ?>
        <?php foreach($categorias as $categoria): ?>
            <div class="categoria-section">
                <div class="categoria-titulo">
                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                </div>
                <?php if($categoria['descripcion']): ?>
                    <div class="categoria-descripcion">
                        <?php echo htmlspecialchars($categoria['descripcion']); ?>
                    </div>
                <?php endif; ?>

                <div class="servicios-grid">
                    <?php if(empty($categoria['servicios'])): ?>
                        <div class="sin-servicios">
                            No hay servicios en esta categoría aún.
                        </div>
                    <?php else: ?>
                        <?php foreach($categoria['servicios'] as $servicio): ?>
                            <div class="servicio-card" onclick="abrirPanel(<?php echo htmlspecialchars(json_encode($servicio)); ?>, '<?php echo htmlspecialchars($categoria['nombre']); ?>')">
                                <?php if($servicio['imagen']): ?>
                                    <div class="servicio-imagen">
                                        <img src="<?php echo htmlspecialchars($servicio['imagen']); ?>" alt="<?php echo htmlspecialchars($servicio['nombre']); ?>">
                                    </div>
                                <?php else: ?>
                                    <div class="servicio-imagen">
                                        <img src="../../public/img/default.png" alt="Servicio">
                                    </div>
                                <?php endif; ?>
                                <div class="servicio-nombre">
                                    <?php echo htmlspecialchars($servicio['nombre']); ?>
                                </div>
                                <div class="servicio-descripcion">
                                    <?php echo htmlspecialchars(substr($servicio['descripcion'] ?? 'Descripción no disponible', 0, 80)); ?>...
                                </div>
                                <?php if($usuarioLogueado): ?>
                                    <a href="solicitar_servicio.php?id=<?php echo $servicio['id']; ?>" class="btn-cotizar" onclick="event.stopPropagation();">
                                        📝 Solicitar Cotización
                                    </a>
                                <?php else: ?>
                                    <a href="login.php" class="btn-cotizar" style="background: #95a5a6;" onclick="event.stopPropagation();">
                                        🔒 Inicia sesión para cotizar
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- OVERLAY (fondo oscuro) -->
<div id="overlay" class="overlay" onclick="cerrarPanel()"></div>

<!-- PANEL LATERAL DERECHO -->
<div id="detallePanel" class="detalle-panel">
    <div class="detalle-header">
        <h3>Detalle del Servicio</h3>
        <button class="btn-cerrar-panel" onclick="cerrarPanel()">&times;</button>
    </div>
    <div class="detalle-contenido">
        <div class="detalle-imagen">
            <img id="panelImagen" src="" alt="Servicio">
        </div>
        <div class="detalle-nombre" id="panelNombre"></div>
        <div class="detalle-categoria" id="panelCategoria"></div>
        <div class="detalle-descripcion" id="panelDescripcion"></div>
        <div class="detalle-footer">
            <a id="panelBotonCotizar" href="#" class="btn-cotizar-panel">📝 Solicitar Cotización</a>
        </div>
    </div>
</div>

<script>
    // ========== CARRUSEL ==========
    let slideIndex = 0;
    const slides = document.querySelectorAll('.carrusel-slide');
    const dots = document.querySelectorAll('.dot');
    const totalSlides = slides.length;
    
    function actualizarCarrusel() {
        const desplazamiento = -slideIndex * 100;
        document.getElementById('carruselSlides').style.transform = `translateX(${desplazamiento}%)`;
        
        dots.forEach((dot, i) => {
            if (i === slideIndex) {
                dot.classList.add('activo');
            } else {
                dot.classList.remove('activo');
            }
        });
    }
    
    function slideSiguiente() {
        if (slideIndex < totalSlides - 1) {
            slideIndex++;
        } else {
            slideIndex = 0;
        }
        actualizarCarrusel();
    }
    
    function slidePrevio() {
        if (slideIndex > 0) {
            slideIndex--;
        } else {
            slideIndex = totalSlides - 1;
        }
        actualizarCarrusel();
    }
    
    function irSlide(index) {
        slideIndex = index;
        actualizarCarrusel();
    }
    
    // Cambio automático cada 5 segundos
    let intervalo = setInterval(slideSiguiente, 5000);
    
    // Pausar al pasar el mouse
    const carruselContainer = document.querySelector('.carrusel-container');
    if (carruselContainer) {
        carruselContainer.addEventListener('mouseenter', () => {
            clearInterval(intervalo);
        });
        carruselContainer.addEventListener('mouseleave', () => {
            intervalo = setInterval(slideSiguiente, 5000);
        });
    }
    
    // ========== PANEL DE DETALLE ==========
    function abrirPanel(servicio, categoriaNombre) {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('detallePanel').style.display = 'block';
        
        document.getElementById('panelNombre').innerHTML = servicio.nombre;
        document.getElementById('panelDescripcion').innerHTML = servicio.descripcion || 'Descripción no disponible. Consulte con nuestros asesores para más información.';
        document.getElementById('panelCategoria').innerHTML = '📁 ' + categoriaNombre;
        
        if (servicio.imagen) {
            document.getElementById('panelImagen').src = servicio.imagen;
        } else {
            document.getElementById('panelImagen').src = '../../public/img/default.png';
        }
        
        <?php if($usuarioLogueado): ?>
            document.getElementById('panelBotonCotizar').href = 'solicitar_servicio.php?id=' + servicio.id;
            document.getElementById('panelBotonCotizar').innerHTML = '📝 Solicitar Cotización';
            document.getElementById('panelBotonCotizar').style.background = '#2ecc71';
        <?php else: ?>
            document.getElementById('panelBotonCotizar').href = 'login.php';
            document.getElementById('panelBotonCotizar').innerHTML = '🔒 Inicia sesión para cotizar';
            document.getElementById('panelBotonCotizar').style.background = '#95a5a6';
        <?php endif; ?>
    }
    
    function cerrarPanel() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('detallePanel').style.display = 'none';
    }
    
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            cerrarPanel();
        }
    });
</script>

</body>
</html>