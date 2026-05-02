<?php
class Conexion{
    public static function conectar(){
        $config = require __DIR__ . '/../config/database.php';
        try{
            $pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}",
                $config['user'],
                $config['pass']

            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch(PDOException $e){
            die("Error de conexion: " . $e->getMessage());
        }
    }
}
?>