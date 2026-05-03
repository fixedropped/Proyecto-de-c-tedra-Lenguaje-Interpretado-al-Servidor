<?php

require_once 'Conexion.php';

class Usuario {

    private $conexion;

    // =========================
    // PROPIEDADES
    // =========================
    public $id_usuario;
    public $nombre;
    public $email;
    public $password;
    public $telefono;
    public $id_rol;
    public $fecha_registro;

    // =========================
    // CONSTRUCTOR
    // =========================
    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    // =========================
    // CARGAR DATOS
    // =========================
    public function cargarDesdeArray($data) {
        $this->id_usuario     = $data['id_usuario'] ?? null;
        $this->nombre         = $data['nombre'] ?? null;
        $this->email          = $data['email'] ?? null;
        $this->password       = $data['password'] ?? null;
        $this->telefono       = $data['telefono'] ?? null;
        $this->id_rol         = $data['id_rol'] ?? null;
        $this->fecha_registro = $data['fecha_registro'] ?? null;
    }

    // =========================
    // CREAR / ACTUALIZAR
    // =========================
    public function guardar() {

        // INSERT
        if ($this->id_usuario === null) {

            try {

        $sql = "INSERT INTO usuario 
                (nombre, email, password, telefono, id_rol, fecha_registro)
                VALUES 
                (:nombre, :email, :password, :telefono, :id_rol, NOW())";

        $stmt = $this->conexion->prepare($sql);

        $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':id_rol', $this->id_rol);

        $resultado = $stmt->execute();

        if ($resultado) {
            $this->id_usuario = $this->conexion->lastInsertId();
            return true;
        }

        return false;

    } catch (PDOException $e) {

        // 🔥 ERROR DE DUPLICADO (email único, etc.)
        if ($e->getCode() == 23000) {

            // Puedes personalizar según el mensaje
            if (strpos($e->getMessage(), 'email') !== false) {
                return "error_email";
            }

            if (strpos($e->getMessage(), 'telefono') !== false) {
                return "error_telefono";
            }

            return "error_duplicado";
        }

        // OTRO ERROR SQL
        return "error_general";
    }
        }

        // UPDATE
        else {

            $sql = "UPDATE usuario SET
                        nombre = :nombre,
                        email = :email,
                        telefono = :telefono,
                        id_rol = :id_rol
                    WHERE id_usuario = :id";

            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':id_rol', $this->id_rol);
            $stmt->bindParam(':id', $this->id_usuario);

            return $stmt->execute();
        }
    }

    // =========================
    // BUSCAR POR EMAIL
    // =========================
    public static function buscarPorEmail($email) {

        $conexion = Conexion::conectar();

        $sql = "SELECT * FROM usuario WHERE email = :email LIMIT 1";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $usuario = new Usuario();
            $usuario->cargarDesdeArray($data);
            return $usuario;
        }

        return null;
    }

    // =========================
    // BUSCAR POR ID
    // =========================
    public static function buscarPorId($id) {

        $conexion = Conexion::conectar();

        $sql = "SELECT * FROM usuario WHERE id_usuario = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $usuario = new Usuario();
            $usuario->cargarDesdeArray($data);
            return $usuario;
        }

        return null;
    }

    // =========================
    // LISTAR TODOS
    // =========================
    public static function obtenerTodos() {

        $conexion = Conexion::conectar();

        $sql = "SELECT * FROM usuario";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        $usuarios = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $usuario = new Usuario();
            $usuario->cargarDesdeArray($row);
            $usuarios[] = $usuario;
        }

        return $usuarios;
    }

    // =========================
    // SESIÓN
    // =========================
    public function guardarEnSesion() {

        $_SESSION['usuario'] = [
            'data' => [
                'id_usuario' => $this->id_usuario,
                'nombre'     => $this->nombre,
                'email'      => $this->email,
                'id_rol'     => $this->id_rol
            ],
            'tiempo' => time()
        ];
    }

    public static function obtenerDeSesion() {

        if (!isset($_SESSION['usuario'])) {
            return null;
        }

        $sesion = $_SESSION['usuario'];

        // 15 minutos
        if ((time() - $sesion['tiempo']) > 900) {
            self::cerrarSesion();
            return null;
        }

        $usuario = new Usuario();
        $usuario->cargarDesdeArray($sesion['data']);

        return $usuario;
    }

    public static function renovarSesion() {
        if (isset($_SESSION['usuario'])) {
            $_SESSION['usuario']['tiempo'] = time();
        }
    }

    public static function cerrarSesion() {
        unset($_SESSION['usuario']);
    }



        // Verificar si el correo ya existe
    public static function correoExiste($email) {
        $db = Conexion::conectar();

        $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        return $stmt->fetch() ? true : false;
    }

    // Registrar usuario (con contraseña segura)
    public static function registrar($nombre, $email, $password) {
        $db = Conexion::conectar();

        // Encriptar contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $email, $passwordHash]);
    }

}