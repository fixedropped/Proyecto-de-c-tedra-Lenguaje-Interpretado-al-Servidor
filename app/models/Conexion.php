<?php

class Conexion {

    private static $host = "localhost";
    private static $db   = "cc_asociados";
    private static $user = "root";
    private static $pass = "";
    private static $charset = "utf8mb4";

    public static function conectar() {

        try {

            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset;

            $opciones = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // errores como excepciones
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // arrays asociativos
                PDO::ATTR_EMULATE_PREPARES   => false,                  // seguridad en consultas
            ];

            $conexion = new PDO($dsn, self::$user, self::$pass, $opciones);

            return $conexion;

        } catch (PDOException $e) {

            // En producción no muestres errores reales
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }
}