<?php
require_once("../../../modelo/conexion.php");
require_once("../../../modelo/pedido.php");

if (isset($_POST['btncrear']) && isset($_POST['nombre'])) {
    $pedido = new Pedido($conexion);
    $resultado = $pedido->insertarPedido($_POST['nombre']); // Ajusta los parámetros según lo que necesites
    
    if ($resultado !== false) {
        header("Location: ../../../vista/Comanda/comanda_nueva_mesa.php?id_pedido=$resultado");
        exit();
    } else {
        echo "Error al crear el pedido."; // Puedes manejar el error de alguna otra forma
    }
}
?>
