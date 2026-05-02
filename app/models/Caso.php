<?php
require_once "../../config/database.php";

class Caso {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function obtenerCasos() {

        $sql = "SELECT 
                    c.id_caso,
                    c.titulo,
                    c.fecha_inicio,
                    s.nombre AS servicio,
                    ec.estado
                FROM caso c
                LEFT JOIN servicio s ON c.id_servicio = s.id_servicio
                LEFT JOIN (
                    SELECT id_caso, estado 
                    FROM estado_caso 
                    ORDER BY fecha DESC
                ) ec ON c.id_caso = ec.id_caso
                GROUP BY c.id_caso
                ORDER BY c.fecha_inicio DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerCasoPorId($id){

    $sql = "SELECT 
                c.*,
                s.nombre AS servicio,
                u.nombre AS socio,
                ec.estado
            FROM caso c
            LEFT JOIN servicio s ON c.id_servicio = s.id_servicio
            LEFT JOIN usuario u ON c.id_socio = u.id_usuario
            LEFT JOIN estado_caso ec ON c.id_caso = ec.id_caso
            WHERE c.id_caso = ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}