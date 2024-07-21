<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "Administrador") {
    // El usuario no tiene permisos de administrador, redirige a una página de acceso denegado o muestra un mensaje de error.
    header("Location: acceso_denegado.php");
    exit();
}

?>



