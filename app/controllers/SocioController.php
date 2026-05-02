<?php

require_once '../models/Usuario.php';

session_start();

// =========================
// CREAR
// =========================
if (isset($_POST['crear'])) {

    $usuario = new Usuario();

    $usuario->nombre = $_POST['nombre'];
    $usuario->email = $_POST['email'];
    $usuario->password = $_POST['password'];
    $usuario->telefono = $_POST['telefono'];
    $usuario->id_rol = 1; // admin

    $usuario->guardar();

    header("Location: ../views/AgregarSocio.php");
    exit();
}

// =========================
// ELIMINAR
// =========================
if (isset($_GET['eliminar'])) {

    $id = $_GET['eliminar'];

    $conexion = Conexion::conectar();

    $sql = "DELETE FROM usuario WHERE id_usuario = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: ../views/AgregarSocio.php");
    exit();
}