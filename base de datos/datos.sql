-- Insertar más categorías si no existen
INSERT INTO categoria (nombre, descripcion) VALUES
('Derecho Penal', 'Asesoría y defensa en procesos penales, delitos y faltas'),
('Derecho Civil', 'Contratos, propiedades, obligaciones y responsabilidad civil'),
('Derecho Notarial', 'Escrituras, testamentos, traspasos y validación de documentos'),
('Derecho Laboral', 'Relaciones laborales, despidos, prestaciones y demandas');

-- Insertar subcategorías
INSERT INTO subcategoria (nombre, id_categoria) VALUES
('Delitos comunes', 1),
('Delitos económicos', 1),
('Contratos civiles', 2),
('Propiedad horizontal', 2),
('Herencia', 3),
('Traspaso de bienes', 3),
('Validación de documentos', 3),
('Despidos', 4),
('Prestaciones laborales', 4);

-- Insertar servicios
INSERT INTO servicio (nombre, descripcion, id_subcategoria) VALUES
('Robo y hurto', 'Defensa legal en casos de robo, hurto y delitos contra la propiedad', 1),
('Estafas y fraudes', 'Asesoría en casos de estafa, fraude financiero y delitos económicos', 2),
('Lesiones', 'Representación en casos de lesiones personales y agresiones', 1),
('Redacción de contratos', 'Elaboración y revisión de contratos civiles y mercantiles', 3),
('Divorcios', 'Proceso completo de divorcio (con o sin mutuo acuerdo)', 3),
('Problemas de vecinos', 'Asesoría en conflictos de propiedad horizontal y vecindad', 4),
('Testamentos', 'Redacción y validación legal de testamentos', 5),
('Traspaso de vehículos', 'Gestión completa de traspaso de vehículos', 6),
('Autenticación de firmas', 'Validación notarial de firmas en documentos', 7),
('Despido injustificado', 'Demanda y asesoría por despido sin causa justa', 8),
('Cálculo de prestaciones', 'Cálculo de finiquito, liquidación e indemnizaciones', 9);


--Insertar usuarios
INSERT INTO usuario(id_usuario, nombre, email, password) VALUES
('2', 'David', 'admin1@cc.com', '$2y$10$B/qP1FRYd7JUtrn141bmgOVyEPdJ3zBE2EBo1XgmfopLIIaH3wyVm'),
('1', 'Luis Felipe', 'prueba1@gmail.com', '$2y$10$Zm5TcqRMSDo3ugaXMrs4RuyLECXfJcUbtfo1qdVy5g4w6yYcDCHcK')
--Las contraseñas estarán en el manual