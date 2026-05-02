<?php
class Database {
    private $host = "localhost";
    private $db_name = "cc_asociados";
    private $username = "root";
    private $password = "";

    public function conectar() {
        try {
            $conn = new PDO(
                "mysql:host=$this->host;dbname=$this->db_name;charset=utf8",
                $this->username,
                $this->password
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;

        } catch(PDOException $e) {
            throw new Exception("Error de conexión: " . $e->getMessage());
        }
    }
}