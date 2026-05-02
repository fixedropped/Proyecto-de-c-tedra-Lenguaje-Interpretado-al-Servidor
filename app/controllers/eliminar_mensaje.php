<?php
require_once "../models/Mensaje.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $modelo = new Mensaje();

    if ($modelo->eliminar($id)) {
        header("Location: ../views/mensajes.php?msg=eliminado");
    } else {
        header("Location: ../views/mensajes.php?msg=error");
    }

    exit;
}