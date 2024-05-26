<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../../../modelo/conexion.php";

if (isset($_POST['producto_id']) && isset($_POST['accion'])) {
    $producto_id = $_POST['producto_id'];
    $accion = $_POST['accion'];

    if (isset($_SESSION['productos'])) {
        foreach ($_SESSION['productos'] as &$producto) {
            if ($producto['id'] == $producto_id) {
                //boton +
                if ($accion == 'incrementar') {
                    $producto['unidades'] += 1;
                }
                // boton -
                elseif ($accion == 'disminuir' && $producto['unidades'] > 1) {
                    $producto['unidades'] -= 1;
                }
                $producto['subtotal'] = $producto['precio'] * $producto['unidades'];
                break;
            }
        }
    }
}

$mesa_id = $_POST['mesa_id'];
$redirect_url = "/Restaurante/vista/Pedidos/anadir_comanda.php?id=" . $mesa_id;
header("Location: $redirect_url");
exit();
?>