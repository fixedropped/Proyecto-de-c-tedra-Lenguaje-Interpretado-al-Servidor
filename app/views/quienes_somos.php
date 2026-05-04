<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¿Quiénes somos?</title>
    <link rel="stylesheet" href="../../public/css/style.css">

    <style>
        /* CONTENIDO PRINCIPAL */
        .contenido{
            width: 80%;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            text-align: justify;
        }

        .contenido p{
            text-align: justify;
            margin-bottom: 20px;
            line-height: 1.8;
            color: #333;
        }

        /* BORDES LATERALES */
        body::before,
        body::after{
            content: "";
            position: fixed;
            top: 0;
            width: 60px;
            height: 100%;
            background: linear-gradient(#5dade2, #3498db);
            z-index: -1;
        }

        body::before{
            left: 0;
        }

        body::after{
            right: 0;
        }

        /* IMÁGENES */
        .imagen{
            width: 100%;
            height: 200px;
            background: #d6eaf8;
            margin: 20px 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2e86c1;
            font-weight: bold;
        }

        .bloque{
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 30px;
        }

        .bloque .imagen{
            width: 400px;
            height: 300px;
            flex-shrink: 0;
        }

        .bloque .imagen img{
            width: 100%;
            border-radius: 10px;
        }

        .bloque p{
            flex: 1;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Sobre nosotros</h1>
</div>

<!-- 🔵 MENÚ SUPERIOR -->
<div class="menu">
    <a href="quienes_somos.php" class="boton">QUIÉNES SOMOS</a>
    <a href="servicios.php" class="boton">SERVICIOS</a>
    <a href="buzon.php" class="boton">BUZÓN</a>
    <a href="casos.php" class="boton">CASOS ACTUALES</a>
    <a href="login.php" class="boton">INICIAR SESIÓN</a>
</div>

<div class="contenido">

    <div class="bloque">
    <div class="imagen">
        <img src="../../public/img/asuntos legales.jpg" alt="Organizacion CC&Asociados">
    </div>

    <p>
        La firma CC Asociados nació como un proyecto visionario impulsado por un grupo de profesionales del derecho que compartían una misma inquietud: transformar la manera en que se prestaban los servicios legales en su entorno. A inicios de la década de 2010, en un contexto donde muchas firmas tradicionales se mantenían bajo esquemas rígidos y poco accesibles para el ciudadano común, estos abogados decidieron unir esfuerzos para construir una organización diferente, centrada no solo en la excelencia jurídica, sino también en la cercanía con el cliente y la innovación en la gestión de casos.
    </p>
</div>

    <p>
        En sus primeros años, CC Asociados operaba desde una pequeña oficina con recursos limitados, pero con una clara visión estratégica. Su enfoque se basaba en ofrecer asesoría legal integral en áreas clave como derecho civil, mercantil y laboral, priorizando siempre la transparencia y la ética profesional. La confianza que comenzaron a generar entre sus primeros clientes fue fundamental para su crecimiento, ya que el reconocimiento se expandió principalmente a través de recomendaciones directas.
    </p>

    <div class="bloque">
        <div class="imagen">
            <img src="../../public/img/Oficinas legales.jpg" alt="Organizacion CC&Asociados">
    </div>


    <p>
        Con el paso del tiempo, la firma fue ampliando su equipo de trabajo, incorporando especialistas en distintas ramas del derecho, lo que le permitió abordar casos de mayor complejidad. Esta diversificación fue acompañada por la implementación de procesos internos más estructurados, incluyendo sistemas de gestión de casos, control de costos y seguimiento de estados legales, lo que marcó una diferencia significativa frente a otras firmas del mercado.
    </p>
</div>

    <p>
        Uno de los hitos más importantes en la evolución de CC Asociados fue la adopción de herramientas tecnológicas para optimizar su operación. La digitalización de expedientes, la automatización de cotizaciones de servicios legales y la implementación de plataformas internas para el seguimiento de clientes permitieron mejorar la eficiencia y reducir tiempos de respuesta. Esta transformación digital no solo fortaleció su competitividad, sino que también mejoró la experiencia del cliente, ofreciendo mayor claridad y acceso a la información de sus procesos legales.
    </p>

    <div class="bloque">
        <div class="imagen">
            <img src="../../public/img/asuntos legales.jpg" alt="Organizacion CC&Asociados">
    </div>


    <p>
        A medida que la empresa crecía, también lo hacía su compromiso social. CC Asociados comenzó a participar en programas de asesoría legal gratuita para comunidades vulnerables, entendiendo que el acceso a la justicia es un derecho fundamental. Este enfoque reforzó su reputación como una firma no solo rentable, sino también responsable y consciente de su impacto en la sociedad.
    </p>
</div>

    <p>
        En la actualidad, CC Asociados se posiciona como una firma consolidada, reconocida por su profesionalismo, innovación y enfoque centrado en el cliente. Su modelo de trabajo combina la experiencia tradicional del derecho con herramientas modernas de gestión, permitiendo ofrecer soluciones legales eficientes, personalizadas y adaptadas a las necesidades actuales. La empresa continúa en constante evolución, explorando nuevas tecnologías y metodologías que le permitan mantenerse a la vanguardia en un entorno legal cada vez más dinámico.
    </p>

    <p>
        La historia de CC Asociados es un reflejo de cómo la visión, la disciplina y la capacidad de adaptación pueden transformar una idea inicial en una organización sólida y respetada. Con una base construida sobre valores firmes y una mirada hacia el futuro, la firma sigue avanzando con el objetivo de redefinir el servicio legal en su entorno.
    </p>

</div>

</body>

<!-- FOOTER -->
<footer>
    <p>© 2026 CC & Asociados - Todos los derechos reservados</p>
</footer>
</html>