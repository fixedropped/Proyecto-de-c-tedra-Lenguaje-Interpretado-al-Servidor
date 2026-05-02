<?php
// Procesar formulario de mensajes de forma aislada
require_once "../models/Mensaje.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    
    $id_usuario = 1;
    $asunto = $_POST["asunto"] ?? "";
    $contenido = $_POST["contenido"] ?? "";

    if (!empty($asunto) && !empty($contenido)) {
        try {
            $modelo = new Mensaje();
            if ($modelo->guardar($id_usuario, $asunto, $contenido)) {
                header("Location: ../views/buzon.php?msg=ok", true, 303);
                exit;
            } else {
                header("Location: ../views/buzon.php?msg=error", true, 303);
                exit;
            }
        } catch(Exception $e) {
            header("Location: ../views/buzon.php?msg=error", true, 303);
            exit;
        }
    }
}
// Si no es POST, redirigir al formulario
header("Location: ../views/buzon.php", true, 303);
exit;
