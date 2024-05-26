<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../../../modelo/conexion.php";

if (isset($_POST['mesa_id']) && isset($_SESSION['productos']) && count($_SESSION['productos']) > 0) {
    $mesa_id = $_POST['mesa_id'];

    //obtener el ID del pedido dado la mesa_id
    $statement = $conexion->prepare("CALL ObtenerPedidoPorMesa(?, @pedido_id)");
    $statement->bind_param("i", $mesa_id);
    $statement->execute();
    $statement->close();
    $result = $conexion->query("SELECT @pedido_id AS pedido_id");
    $row = $result->fetch_assoc();
    $pedido_id = $row['pedido_id'];

    //creamos comanda
    $statement = $conexion->prepare("CALL CrearComanda(?)");
    $statement->bind_param("i", $pedido_id);
    $statement->execute();
    $statement->close();

    //obtener el ID de la comanda (obtenido de LAST_INSERT_ID() al hacer el procedimiento de CrearComanda)
    $result = $conexion->query("SELECT LAST_INSERT_ID() AS comanda_id");
    $row = $result->fetch_assoc();
    $comanda_id = $row['comanda_id'];

    // creamos una instancia de `comanda_producto` por fila de la tabla
    $statement = $conexion->prepare("CALL AnadirProductoAComanda(?, ?, ?)");
    foreach ($_SESSION['productos'] as $producto) {
        $statement->bind_param("iii", $comanda_id, $producto['id'], $producto['unidades']);
        $statement->execute();
    }
    $statement->close();

    //calculamos el precio final y lo actualizamos (seleccionando la fila con el total y luego asignándole el precio al pedido)
    $statement = $conexion->prepare("CALL CalcularPrecioFinalPedidoConCursor(?, @precio_final)");
    $statement->bind_param("i", $pedido_id);
    $statement->execute();
    $statement->close();
    $result = $conexion->query("SELECT @precio_final AS precio_final");
    $row = $result->fetch_assoc();
    $total = $row['precio_final'];
    $statement = $conexion->prepare("UPDATE pedido SET precio = ? WHERE id = ?");
    $statement->bind_param("di", $total, $pedido_id);
    $statement->execute();
    $statement->close();

    //limpiar los productos de la tabla
    unset($_SESSION['productos']);
}

$redirect_url = "/Restaurante/vista/Pedidos/menu.php";
header("Location: $redirect_url");
exit();
?>