<?php
require "../modelo/conexion.php";
require "../modelo/comanda.php";
require "../modelo/pedido.php";

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

        // Crear una nueva comanda si no existe
        $comanda->crearComanda($pedido_mesa['id']);

        // Obtener la última comanda creada para el pedido
        $ultima_comanda = $comanda->obtenerUltimaComandaPorPedido($pedido_mesa['id']);

        // Agregar el producto a la comanda
        $comanda->anadirProductoAComanda($ultima_comanda['id'], $id_producto, $cantidad);

        // Redirigir a la misma página para evitar reenvío de formulario
        header("Location: agregar_comanda.php?id_mesa=$id_mesa");
        exit();
    }
}

// Obtener todas las categorías y productos
$sql_categorias = "CALL sp_restaurante_categoria_seleccionar()";
$result_categorias = $conexion->query($sql_categorias);
$categorias = [];
if ($result_categorias->num_rows > 0) {
    while ($categoria = $result_categorias->fetch_assoc()) {
        $categoria_id = $categoria['id'];
        $sql_productos = "CALL ObtenerProductosPorCategoria(?)";
        $stmt_productos = $conexion->prepare($sql_productos);
        $stmt_productos->bind_param("i", $categoria_id);
        $stmt_productos->execute();
        $result_productos = $stmt_productos->get_result();
        $productos = [];
        if ($result_productos->num_rows > 0) {
            while ($producto = $result_productos->fetch_assoc()) {
                $productos[] = $producto;
            }
        }
        $categorias[] = [
            'categoria' => $categoria,
            'productos' => $productos
        ];
    }
}

// Obtener todas las comandas del pedido para mostrar en la vista
$comandas_pedido = $comanda->obtenerComandasPorPedido($pedido_mesa['id']);
if (!$comandas_pedido) {
    $comandas_pedido = [];
}
?>