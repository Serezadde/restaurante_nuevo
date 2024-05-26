<?php
require "../../modelo/conexion.php";
require "../../modelo/pedido.php";
require "../../modelo/comanda.php";

// Verificar si se ha proporcionado el ID del pedido en la URL o en el formulario
if (!isset($_GET['id_pedido']) && !isset($_POST['id_pedido'])) {
    echo "ID de pedido no válido";
    exit();
}

$id_pedido = isset($_GET['id_pedido']) ? $_GET['id_pedido'] : $_POST['id_pedido'];

$pedidoModel = new Pedido($conexion);
$comandaModel = new Comanda($conexion);

$pedido = $pedidoModel->obtenerPedidoPorId($id_pedido);

// Verificar si se encontró el pedido con el ID proporcionado
if (!$pedido) {
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
