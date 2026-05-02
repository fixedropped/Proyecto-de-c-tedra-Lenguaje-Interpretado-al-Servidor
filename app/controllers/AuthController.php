<?php

require_once '../models/Usuario.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $usuario = Usuario::buscarPorEmail($email);

    if ($usuario) {

        // ⚠️ COMPARACIÓN SIMPLE (modo pruebas)
        if ($password === $usuario->password) {

            $usuario->guardarEnSesion();

            // 🔥 REDIRECCIÓN POR ROL
            if ($usuario->id_rol == 1) {
                header("Location: ../views/menu_admin.php");
                exit();
            } else if ($usuario->id_rol == 2) {
                header("Location: ../views/servicios.php");
                exit();
            }

        } else {
            header("Location: ../../public/views/login.php?error=1");
            exit();
        }

    } else {
        header("Location: ../../public/views/login.php?error=1");
        exit();
    }
}