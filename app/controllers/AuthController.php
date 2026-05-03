<?php

require_once '../models/Usuario.php';

session_start();

// =========================
// LOGIN
// =========================
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];


        // Validar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        header("Location: ../views/login.php?error=campos_vacios");
        exit();
    }

    // Validar formato de email (expresión regular)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../views/login.php?error=email_invalido");
        exit();
    }


    $usuario = Usuario::buscarPorEmail($email);

    // Verificar que el usuario existe Y la contraseña es correcta (usando password_verify)
    if ($usuario && password_verify($password, $usuario->password)) {

        // Renovar sesión antes de guardar
        $usuario->guardarEnSesion();

        // Redirigir según el rol
        if ($usuario->id_rol == 1) {  // socio/admin
            header("Location: ../views/menu_admin.php");
        } else {                        // cliente
            header("Location: ../views/servicios.php");
        }
        exit();

    } else {
        // Error genérico para no dar pistas (seguridad)
        header("Location: ../views/login.php?error=credenciales");
        exit();
    }
}

// =========================
// REGISTRO
// =========================
if (isset($_POST['registro'])) {

    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email_reg']);
    $password = $_POST['password_reg'];
    $telefono = trim($_POST['telefono'] ?? '');

    // =============================================
    // VALIDACIONES DEL LADO DEL SERVIDOR
    // =============================================

    $errores = [];

    // 1. Validar que ningún campo obligatorio esté vacío
    if (empty($nombre)) {
        $errores[] = "nombre_vacio";
    }
    if (empty($email)) {
        $errores[] = "email_vacio";
    }
    if (empty($password)) {
        $errores[] = "password_vacio";
    }

    // 2. Validar formato de email
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "email_invalido";
    }

    // 3. Validar que la contraseña tenga al menos 6 caracteres
    if (!empty($password) && strlen($password) < 6) {
        $errores[] = "password_corta";
    }

    // 4. Validar teléfono (opcional, pero si se ingresa, que tenga formato válido)
    if (!empty($telefono) && !preg_match('/^[0-9\-\(\)\/\+]{8,15}$/', $telefono)) {
        $errores[] = "telefono_invalido";
    }

    // 5. Validar nombre (solo letras y espacios)
    if (!empty($nombre) && !preg_match('/^[a-zA-ZáéíóúñÑÁÉÍÓÚ\s]{2,100}$/', $nombre)) {
        $errores[] = "nombre_invalido";
    }

    // Si hay errores, redirigir con el mensaje
    if (!empty($errores)) {
        $error_str = implode(',', $errores);
        header("Location: ../views/registro.php?error_registro=" . $error_str);
        exit();
    }

    // Crear usuario
    $usuario = new Usuario();

    $usuario->nombre = $nombre;
    $usuario->email = $email;
    $usuario->password = $password;  // Se encriptará dentro del método guardar()
    $usuario->telefono = $telefono;
    $usuario->id_rol = 2; // cliente (rol 2)

    $resultado = $usuario->guardar();

    if ($resultado === true) {
        header("Location: ../views/login.php?registro=ok");
    } elseif ($resultado === "error_email") {
        header("Location: ../views/registro.php?error_registro=email_existe");
    } else {
        header("Location: ../views/registro.php?error_registro=general");
    }
    exit();
}

// =========================
// CERRAR SESIÓN
// =========================
if (isset($_GET['logout'])) {
    Usuario::cerrarSesion();
    header("Location: ../views/login.php");
    exit();
}
?>