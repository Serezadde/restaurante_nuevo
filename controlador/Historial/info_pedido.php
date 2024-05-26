<?php
require "../../modelo/conexion.php";
require "../../modelo/util.php";


if (isset($_GET['id'])) {
    $id_pedido = $_GET['id'];


    $sql = $conexion->prepare("CALL sp_restaurante_pedido_detalle(?)");
    $sql->bind_param("i", $id_pedido);
    $sql->execute();
    $resultado = $sql->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
?>
        <div class="details">
            <div class="details-column">
                <h2>ID Pedido</h2>
                <p><?php echo $fila["id_pedido"]; ?></p>
            </div>

            <div class="details-column">
                <h2>Estado del pedido:</h2>
                <p><?php echo obtenerIcono($fila["en_curso"]); ?></p>
            </div>

            <div class="details-column">
                <h2>Fecha</h2>
                <p><?php echo $fila["fecha"]; ?></p>
            </div>
            <div class="details-column">
                <h2>Mesa</h2>
                <p><?php echo $fila["nombre_mesa"]; ?></p>
            </div>
            <div class="details-column">
                <h2>Precio Total</h2>
                <p><?php echo $fila["precio_total"]; ?>€ </p>
            </div>
        </div>
<?php
    } else {
        echo "No se encontró ningún pedido con el ID proporcionado.";
    }
} else {
    echo "No se proporcionó ningún ID de pedido.";
}
?>
