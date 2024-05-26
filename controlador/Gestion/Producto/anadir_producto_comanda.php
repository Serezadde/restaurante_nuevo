<?php
// Si la sesión no está iniciada, no se añadirán correctamente los productos a la tabla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../../../modelo/conexion.php";

if (isset($_POST['seleccionProd']) && isset($_POST['mesa_id'])) {
    $producto_id = $_POST['seleccionProd'];
    $mesa_id = $_POST['mesa_id'];

    //verifica si el producto ya está en la tabla
    $producto_existente = false;
    if (isset($_SESSION['productos'])) {
        foreach ($_SESSION['productos'] as $producto) {
            if ($producto['id'] == $producto_id) {
                $producto_existente = true;
                break;
            }
        }
    }

    if (!$producto_existente) {
        $sql = "SELECT nombre, precio FROM producto WHERE id = ?";
        $statement = $conexion->prepare($sql);
        $statement->bind_param("i", $producto_id);
        $statement->execute();
        $result = $statement->get_result();
        
        if ($result->num_rows > 0) {
            $producto = $result->fetch_assoc();
            $nombre = $producto['nombre'];
            $precio = $producto['precio'];
            $unidades = 1;
            $subtotal = $precio * $unidades;
            
            $producto_agregado = [
                'id' => $producto_id,
                'nombre' => $nombre,
                'precio' => $precio,
                'unidades' => $unidades,
                'subtotal' => $subtotal
            ];

            if (!isset($_SESSION['productos'])) {
                $_SESSION['productos'] = [];
            }

            $_SESSION['productos'][] = $producto_agregado;
        }
    }
}

//vuelve atrás (con la misma mesa ID de anteriormente para no perderla)
$redirect_url = "/Restaurante/vista/Pedidos/anadir_comanda.php?id=" . $mesa_id;
header("Location: $redirect_url");
exit();
?>