<?php
require "../../modelo/conexion.php";


if (isset($_GET['id'])) {
    $id_pedido = $_GET['id'];

  
    $sql = $conexion->prepare("CALL sp_restaurante_obtener_productos_pedido(?)");
    $sql->bind_param("i", $id_pedido);
    $sql->execute();
    $resultado = $sql->get_result();

    // Mostrar los productos del pedido
    while ($datos = $resultado->fetch_object()) {
?>
        <tr>
            <td><?= $datos->Producto ?></td>
            <td><?= $datos->Precio ?></td>
            <td><?= $datos->Unidades ?></td>
            <td><?= $datos->Subtotal ?></td>
        </tr>
<?php
    }
}
?>
