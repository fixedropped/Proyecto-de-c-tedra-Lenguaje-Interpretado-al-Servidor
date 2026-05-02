<?php

require_once '../models/Usuario.php';

session_start();

// =========================
// LOGIN
// =========================
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $usuario = Usuario::buscarPorEmail($email);

    if ($usuario && $password === $usuario->password) {

        $usuario->guardarEnSesion();

        if ($usuario->id_rol == 1) {
            header("Location: ../views/menu_admin.php");
        } else {
            header("Location: ../views/servicios.php");
        }
        exit();

    } else {
        header("Location: ../views/login.php?error=1");
        exit();
    }
}

// =========================
// REGISTRO
// =========================
if (isset($_POST['registro'])) {

    $usuario = new Usuario();

    $usuario->nombre = $_POST['nombre'];
    $usuario->email = $_POST['email_reg'];
    $usuario->password = $_POST['password_reg'];
    $usuario->telefono = $_POST['telefono'];
    $usuario->id_rol = 2; // usuario normal

    $usuario->guardar();

    header("Location: ../views/login.php?registro=ok");
    exit();
}