<?php
require_once '../../config/database.php';

class Servicio {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    /**
     * Obtener todas las categorías con sus servicios
     */
    public function obtenerCategoriasConServicios() {
        
        $sql = "SELECT 
                    c.id_categoria,
                    c.nombre AS categoria_nombre,
                    c.descripcion AS categoria_descripcion,
                    s.id_servicio,
                    s.nombre AS servicio_nombre,
                    s.descripcion AS servicio_descripcion,
                    s.imagen
                FROM categoria c
                LEFT JOIN subcategoria sub ON c.id_categoria = sub.id_categoria
                LEFT JOIN servicio s ON sub.id_subcategoria = s.id_subcategoria
                ORDER BY c.id_categoria, s.id_servicio";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $categorias = [];
        foreach ($resultados as $row) {
            $cat_id = $row['id_categoria'];
            
            if (!isset($categorias[$cat_id])) {
                $categorias[$cat_id] = [
                    'id' => $cat_id,
                    'nombre' => $row['categoria_nombre'],
                    'descripcion' => $row['categoria_descripcion'],
                    'servicios' => []
                ];
            }
            
            if ($row['id_servicio']) {
                $categorias[$cat_id]['servicios'][] = [
                    'id' => $row['id_servicio'],
                    'nombre' => $row['servicio_nombre'],
                    'descripcion' => $row['servicio_descripcion'],
                    'imagen' => $row['imagen'] ? '../../public/' . $row['imagen'] : null
                ];
            }
        }
        
        return $categorias;
    }

    /**
     * Obtener un servicio por su ID
     */
    public function obtenerServicioPorId($id) {
        $sql = "SELECT * FROM servicio WHERE id_servicio = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener todos los servicios (para selects del admin)
     */
    public function obtenerTodosServicios() {
        $sql = "SELECT id_servicio, nombre, imagen FROM servicio ORDER BY nombre";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener todos los servicios con su categoría y subcategoría
     */
    public function obtenerTodosServiciosCompleto() {
        $sql = "SELECT 
                    s.id_servicio,
                    s.nombre,
                    s.descripcion,
                    s.imagen,
                    s.id_subcategoria,
                    sub.nombre AS subcategoria_nombre,
                    cat.id_categoria,
                    cat.nombre AS categoria_nombre
                FROM servicio s
                LEFT JOIN subcategoria sub ON s.id_subcategoria = sub.id_subcategoria
                LEFT JOIN categoria cat ON sub.id_categoria = cat.id_categoria
                ORDER BY cat.id_categoria, sub.nombre, s.nombre";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($resultados as &$row) {
            $row['categoria_nombre'] = $row['categoria_nombre'] ?? 'Sin categoría';
            $row['subcategoria_nombre'] = $row['subcategoria_nombre'] ?? 'Sin subcategoría';
            $row['descripcion'] = $row['descripcion'] ?? '';
        }
        
        return $resultados;
    }

    /**
     * Obtener un servicio completo por ID
     */
    public function obtenerServicioCompletoPorId($id) {
        $sql = "SELECT 
                    s.*,
                    s.id_subcategoria,
                    sub.id_categoria
                FROM servicio s
                LEFT JOIN subcategoria sub ON s.id_subcategoria = sub.id_subcategoria
                WHERE s.id_servicio = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crear un nuevo servicio
     */
    public function crearServicio($nombre, $descripcion, $id_subcategoria, $imagen = null) {
        $sql = "INSERT INTO servicio (nombre, descripcion, id_subcategoria, imagen) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $id_subcategoria, $imagen]);
    }

    /**
     * Actualizar un servicio (incluyendo imagen)
     */
    public function actualizarServicio($id, $nombre, $descripcion, $id_subcategoria, $imagen = null) {
        if ($imagen) {
            $sql = "UPDATE servicio SET nombre = ?, descripcion = ?, id_subcategoria = ?, imagen = ? WHERE id_servicio = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$nombre, $descripcion, $id_subcategoria, $imagen, $id]);
        } else {
            $sql = "UPDATE servicio SET nombre = ?, descripcion = ?, id_subcategoria = ? WHERE id_servicio = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$nombre, $descripcion, $id_subcategoria, $id]);
        }
    }

    /**
     * Eliminar un servicio
     */
    public function eliminarServicio($id) {
        $sql = "DELETE FROM servicio WHERE id_servicio = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Obtener todas las categorías
     */
    public function obtenerCategorias() {
        $sql = "SELECT id_categoria, nombre FROM categoria ORDER BY nombre";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener todas las subcategorías
     */
    public function obtenerTodasSubcategorias() {
        $sql = "SELECT id_subcategoria, nombre, id_categoria FROM subcategoria ORDER BY nombre";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>