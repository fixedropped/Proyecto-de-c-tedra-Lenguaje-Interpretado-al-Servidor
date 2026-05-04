# Proyecto-de-cátedra-Lenguaje-Interpretado-al-Servidor
# CC & Asociados - Sistema Web
Aplicacion web desarrollada para la gestión de servicios legales, consultas de usuarios
Siguiendo el patrón de arquitectura MVC

# Descripción
El proyecto permite:
- Visualizar información de servicios legales
- Consultar y cotizar servicios disponibles
- Manejar consultas o comentarios de usuarios
- Gestión de socios
- Gestión de servicios
- Gestión de Usuarios

## Requisitos
- PHP 8.1+ (recomendado 8.2/8.3)
- Servidor local: **WAMP / XAMPP / Laragon**
- Navegador moderno (Chrome/Edge/Firefox)
- HTML5
- CSS3
- JS
- DockerFile
- MYSQL

# Estructura del proyecto
/proyeto-de-c-tedra-Lenguaje-Interpretado-al-Servidor
|
├──App/
|  ├──Controllers/
|     AuthController.php
|     eliminar_mensaje.php
|     procesar_mensaje.php
|     SocioController.php
|     subir_archivo.php
|  ├──Models/
|     caso.php
|     Conexion.php
|     Mensaje.php
|     Servicio.php
|     Usuario.php
|  ├──Views/   
|     admin_caso_costo.php
|     admin_casos.php
|     admin_servicios.phpp
|     Agregar_socio.php
|     buzon.php
|     BuzonAdmin.php
|     casos.php
|     Clientes_admin.php
|     Comunicacion.php
|     Cotizaciones.php
|     login.php
|     mensajes.php
|     menu_admin.php
|     quienes_somos.php
|     registro.php
|     solicitar_servicio.php
|     ver_caso.php
|
├──Base de Datos/
|   base de datos.sql
|
├──Config/
|   database.php
|
├──Public/
|   index.php
|   ├──css/
|       BuzonAdmin.css
|       index.css
|       login.css
|       menu_admin.css
|       socio.css
|       style.css
|   ├──js/
|       BuzonAdmin.js
|       login.js
|   ├──img/
|       asuntos legales.jpg
|       Autentificacion de firmas.jpg
|       Contrato.png
|       Despido.png
|       Divorcio.jpg
|       Fraude.png
|       Lesion.png
|       Oficinas legales.jpg
|       Prestaciones.png
|       Redaccion de contratos.png
|       Robo.png
|       Testamento.png
|       Traspaso de vehiculos.png
|       Vecinos.jpg
|
├──Readme.md

# Instalación y ejecucioón
1. Crear una carpeta en los archivos htdocs de Xaamp o www de Waamp
2. Clonar el repositorio de Github:
https://github.com/fixedropped/Proyecto-de-c-tedra-Lenguaje-Interpretado-al-Servidor.git
3. Iniciar Apache y MySQL
4. Crear base de datos segun el archvio almacenado en base de datos "base de datos.sql"
5. Insertar datos almacenados en "datos.sql"
6. Acceder desde el navegador en local
http://localhost/Proyecto-de-c-tedra-Lenguaje-Interpretado-al-Servidor
## Autores
Proyecto de cátedra Fase 2 – 2026-05-03
Luis Felipe Cuadra Cruz                                   CC230464
Marvin José Guillén Lemus                                 GL210911
Gerardo José Villanueva Hernandez                         VH230527
Romeo Vladimir Martínez Pérez                             MP222850
