<?php

if(isset($_FILES['archivo'])){

    $nombre = $_FILES['archivo']['name'];
    $tmp = $_FILES['archivo']['tmp_name'];

    $ruta = "../../public/uploads/" . $nombre;

    move_uploaded_file($tmp, $ruta);

    header("Location: ../views/ver_caso.php?id=" . $_POST['id_caso']);
}