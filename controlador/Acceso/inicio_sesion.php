<?php
require_once "../../modelo/usuario.php";

if (isset($_POST['usuario']) && isset($_POST['password'])) {
    $nombre = $_POST['usuario'];
    $password = $_POST['password'];

    $usuario = new Usuario();
    $usuario->setNombre($nombre);
    $usuario->setPassword($password);

    if ($usuario->verificarCredenciales()) {
        header("Location: ../Administracion/administración_menu.php");
        exit();
    }
    else {
        echo '<div class="alert alert-warning">Credenciales inválidas o usuario no disponible</div>';
    
    }
}