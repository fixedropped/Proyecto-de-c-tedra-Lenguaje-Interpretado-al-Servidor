-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS cc_asociados;
USE cc_asociados;

-- Tabla rol (define los tipos de usuario)
CREATE TABLE rol (
    id_rol INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE
);

-- Insertar los roles básicos
INSERT INTO rol (nombre_rol) VALUES ('cliente'), ('socio');

-- Tabla usuario (guarda a clientes y socios)
CREATE TABLE usuario (
    id_usuario INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    id_rol INT(11) NOT NULL,
    fecha_registro DATETIME NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES rol(id_rol)
);

-- Tabla categoria (clasificación de servicios legales)
CREATE TABLE categoria (
    id_categoria INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- Tabla subcategoria (detalle dentro de una categoría)
CREATE TABLE subcategoria (
    id_subcategoria INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_categoria INT(11) NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria)
);

-- Tabla servicio (servicios específicos que ofrece la empresa)
CREATE TABLE servicio (
    id_servicio INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    id_subcategoria INT(11),
    FOREIGN KEY (id_subcategoria) REFERENCES subcategoria(id_subcategoria)
);

-- Tabla caso (casos legales)
CREATE TABLE caso (
    id_caso INT(11) AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    fecha_inicio DATE NOT NULL,
    fecha_cierre DATE,
    id_cliente INT(11) NOT NULL,
    id_socio INT(11) NOT NULL,
    id_servicio INT(11),
    FOREIGN KEY (id_cliente) REFERENCES usuario(id_usuario),
    FOREIGN KEY (id_socio) REFERENCES usuario(id_usuario),
    FOREIGN KEY (id_servicio) REFERENCES servicio(id_servicio),
    CHECK (fecha_cierre IS NULL OR fecha_cierre >= fecha_inicio)
);

-- Tabla estado_caso (historial de estados de un caso)
CREATE TABLE estado_caso (
    id_estado INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_caso INT(11) NOT NULL,
    estado VARCHAR(50) NOT NULL,
    fecha DATETIME NOT NULL,
    comentario TEXT,
    FOREIGN KEY (id_caso) REFERENCES caso(id_caso)
);

-- Tabla costo (costos asociados a un caso)
CREATE TABLE costo (
    id_costo INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_caso INT(11) NOT NULL,
    concepto VARCHAR(255) NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    fecha DATE NOT NULL,
    FOREIGN KEY (id_caso) REFERENCES caso(id_caso),
    CHECK (monto >= 0)
);

-- Tabla mensaje (buzón de sugerencias y consultas)
CREATE TABLE mensaje (
    id_mensaje INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT(11) NOT NULL,
    asunto VARCHAR(200) NOT NULL,
    contenido TEXT NOT NULL,
    fecha_envio DATETIME NOT NULL,
    leido BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);