<?php
require "../../modelo/conexion.php";
require "../../modelo/pedido.php";
require "../../modelo/comanda.php";

// Verificar si se ha seleccionado una mesa
if (!isset($_GET['id_mesa'])) {
    // Redirigir a la página de selección de mesa
    header("Location: seleccionar_mesa.php");
    exit();
}

$pedido = new Pedido($conexion);
$comanda = new Comanda($conexion);

$id_mesa = $_GET['id_mesa'];

// Obtener el pedido asociado a la mesa seleccionada
$pedido_mesa = $pedido->obtenerPedidoPorMesa($id_mesa);

// Verificar si hay un pedido asociado a la mesa
if (!$pedido_mesa) {
    // Si no hay un pedido, redirigir a la página de selección de mesa
    header("Location: seleccionar_mesa.php");
    exit();
}

// Manejar la creación de una nueva comanda
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['guardar_comanda'])) {
        // Obtener datos del formulario
        $id_producto = $_POST['id_producto'];
        $cantidad = $_POST['cantidad'];

        // Agregar la nueva comanda al pedido
        $comanda->agregarComanda($pedido_mesa['id'], $id_producto, $cantidad);

        // Redirigir a la misma página para evitar reenvío de formulario
        header("Location: agregar_comanda.php?id_mesa=$id_mesa");
        exit();
    }
}

// Obtener todos los productos para mostrar en el formulario
$productos = $comanda->obtenerProductos();

// Obtener todas las comandas del pedido para mostrar en la vista
$comandas_pedido = $comanda->obtenerComandasPorPedido($pedido_mesa['id']);
?>
