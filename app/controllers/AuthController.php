<?php

require_once '../models/Usuario.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $usuario = Usuario::buscarPorEmail($email);

    if ($usuario && password_verify($password, $usuario->password)) {

        // Guardar sesión
        $usuario->guardarEnSesion();

        // 🔥 VALIDAR ROL
        if ($usuario->id_rol == 1) {
            // ADMIN
            header('Location: /../views/menu_admin.php');
            exit();
        } else if ($usuario->id_rol == 2) {
            // USUARIO NORMAL
            header('Location: /../views/menu_admin.php');
            exit();
        } else {
            echo "❌ Rol no reconocido";
        }

    } else {
        echo "❌ Credenciales incorrectas";
    }
}