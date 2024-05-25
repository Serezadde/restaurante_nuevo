<?php
require "../../modelo/conexion.php";
require "../../modelo/pedido.php";
require "../../modelo/comanda.php";


$pedidoModel = new Pedido($conexion);
$comandaModel = new Comanda($conexion);

$id_pedido = $_GET['id_pedido'];
$pedido = $pedidoModel->obtenerPedidoPorId($id_pedido);
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
        header("Location: historial_pedidos.php");
        exit();
    }
}
?>