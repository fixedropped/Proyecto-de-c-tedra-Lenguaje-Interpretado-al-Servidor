<?php
require_once '../../config/database.php';

class Caso {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    /**
     * Obtener casos de un cliente específico
     */
    public function obtenerCasosPorCliente($id_cliente) {

        $sql = "SELECT 
                    c.id_caso,
                    c.titulo,
                    c.fecha_inicio,
                    s.nombre AS servicio,
                    ec.estado,
                    (SELECT SUM(monto) FROM costo WHERE id_caso = c.id_caso) AS total_costos
                FROM caso c
                LEFT JOIN servicio s ON c.id_servicio = s.id_servicio
                LEFT JOIN (
                    SELECT id_caso, estado 
                    FROM estado_caso 
                    ORDER BY fecha DESC
                ) ec ON c.id_caso = ec.id_caso
                WHERE c.id_cliente = :id_cliente
                GROUP BY c.id_caso
                ORDER BY c.fecha_inicio DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener todos los casos (para admin)
     */
    public function obtenerTodosLosCasos() {

        $sql = "SELECT 
                    c.id_caso,
                    c.titulo,
                    c.fecha_inicio,
                    c.fecha_cierre,
                    s.nombre AS servicio,
                    u.nombre AS cliente,
                    (SELECT estado FROM estado_caso WHERE id_caso = c.id_caso ORDER BY fecha DESC LIMIT 1) AS estado
                FROM caso c
                LEFT JOIN servicio s ON c.id_servicio = s.id_servicio
                LEFT JOIN usuario u ON c.id_cliente = u.id_usuario
                ORDER BY c.fecha_inicio DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener un caso por ID (con verificación de cliente opcional)
     */
    public function obtenerCasoPorId($id, $id_cliente = null) {

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
        
        if ($id_cliente !== null) {
            $sql .= " AND c.id_cliente = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id, $id_cliente]);
        } else {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener costos de un caso
     */
    public function obtenerCostosPorCaso($id_caso) {
        $sql = "SELECT * FROM costo WHERE id_caso = ? ORDER BY fecha";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_caso]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crear un nuevo caso (admin)
     */
    public function crearCaso($titulo, $descripcion, $fecha_inicio, $id_cliente, $id_socio, $id_servicio) {
        $sql = "INSERT INTO caso (titulo, descripcion, fecha_inicio, id_cliente, id_socio, id_servicio) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$titulo, $descripcion, $fecha_inicio, $id_cliente, $id_socio, $id_servicio]);
    }

    /**
     * Actualizar un caso (admin)
     */
    public function actualizarCaso($id_caso, $titulo, $descripcion, $fecha_inicio, $fecha_cierre, $id_socio, $id_servicio) {
        $sql = "UPDATE caso SET 
                    titulo = ?, 
                    descripcion = ?, 
                    fecha_inicio = ?, 
                    fecha_cierre = ?, 
                    id_socio = ?, 
                    id_servicio = ?
                WHERE id_caso = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$titulo, $descripcion, $fecha_inicio, $fecha_cierre, $id_socio, $id_servicio, $id_caso]);
    }

    /**
     * Eliminar un caso (admin)
     */
    public function eliminarCaso($id_caso) {
        try {
            // Primero eliminar estados relacionados
            $stmt_estado = $this->conn->prepare("DELETE FROM estado_caso WHERE id_caso = ?");
            $stmt_estado->execute([$id_caso]);
            
            // Eliminar costos relacionados
            $stmt_costo = $this->conn->prepare("DELETE FROM costo WHERE id_caso = ?");
            $stmt_costo->execute([$id_caso]);
            
            // Eliminar caso
            $stmt = $this->conn->prepare("DELETE FROM caso WHERE id_caso = ?");
            return $stmt->execute([$id_caso]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Cambiar estado de un caso y agregar comentario
     */
    public function cambiarEstado($id_caso, $nuevo_estado, $comentario) {
        $sql = "INSERT INTO estado_caso (id_caso, estado, fecha, comentario) VALUES (?, ?, NOW(), ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_caso, $nuevo_estado, $comentario]);
    }

    /**
     * Agregar costo a un caso
     */
    public function agregarCosto($id_caso, $concepto, $monto, $fecha) {
        $sql = "INSERT INTO costo (id_caso, concepto, monto, fecha) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_caso, $concepto, $monto, $fecha]);
    }

    /**
     * Obtener todos los socios (usuarios con rol 1)
     */
    public function obtenerSocios() {
        $sql = "SELECT id_usuario, nombre FROM usuario WHERE id_rol = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener todos los clientes (usuarios con rol 2)
     */
    public function obtenerClientes() {
        $sql = "SELECT id_usuario, nombre, email FROM usuario WHERE id_rol = 2";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener todos los servicios para selects
     */
    public function obtenerTodosServicios() {
        $sql = "SELECT id_servicio, nombre FROM servicio ORDER BY nombre";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>