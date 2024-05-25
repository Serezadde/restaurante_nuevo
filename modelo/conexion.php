<?php 
$conexion=new mysqli("localhost","root","","restaurante","3306");
$conexion->set_charset("utf8") ;

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>