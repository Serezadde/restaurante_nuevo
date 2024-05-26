<?php
require "../../modelo/conexion.php";
require "../../modelo/pedido.php";
require "../../modelo/comanda.php";

// Verificar si se ha proporcionado el ID del pedido en la URL
if (!isset($_GET['id_pedido']) || !is_numeric($_GET['id_pedido'])) {
    // Manejar el caso cuando no se proporciona un ID de pedido válido
    echo "ID de pedido no válido";
    exit();
}

$pedidoModel = new Pedido($conexion);
$comandaModel = new Comanda($conexion);

$id_pedido = $_GET['id_pedido'];
$pedido = $pedidoModel->obtenerPedidoPorId($id_pedido);

// Verificar si se encontró el pedido con el ID proporcionado
if (!$pedido) {
    // Manejar el caso cuando no se encuentra un pedido con el ID proporcionado
    echo "Pedido no encontrado";
    exit();
}

$comandas = $comandaModel->obtenerComandasPorPedido($id_pedido);

$total = 0;
$detalle_comandas = [];
while ($row = $comandas->fetch_assoc()) {
    $total += $row['precio'] * $row['cantidad'];
    $detalle_comandas[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pagar_dinero'])) {
        $pagado = $_POST['dinero_pagado'];
        $devolucion = $pagado - $total;
        $forma_pago = 'dinero';
    } elseif (isset($_POST['pagar_tarjeta'])) {
        $pagado = $total;
        $devolucion = 0;
        $forma_pago = 'tarjeta';
    }

    if (isset($_POST['finalizar'])) {
        $pedidoModel->finalizarPedido($id_pedido);
        header("Location: ../../vista/Pedidos/menu.php");
        exit();
    }
}
?>
