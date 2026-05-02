<?php
require_once "../../config/database.php";

class Mensaje {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function guardar($id_usuario, $asunto, $contenido) {

        $sql = "INSERT INTO mensaje 
                (id_usuario, asunto, contenido, fecha_envio, leido) 
                VALUES (?, ?, ?, NOW(), 0)";

        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute([$id_usuario, $asunto, $contenido])) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerTodos() {
    $sql = "SELECT m.*, u.nombre 
            FROM mensaje m
            JOIN usuario u ON m.id_usuario = u.id_usuario
            ORDER BY m.fecha_envio DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function eliminar($id) {
    $sql = "DELETE FROM mensaje WHERE id_mensaje = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
}
}
