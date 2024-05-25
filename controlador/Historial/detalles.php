<?php
// Verificar si se ha proporcionado un ID de pedido en la URL
if(isset($_GET['id'])) {
    // Obtener el ID del pedido de la URL
    $id_pedido = $_GET['id'];

    // Establecer la conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "restaurante", "3306");
    $conexion->set_charset("utf8");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta SQL para obtener los detalles del pedido
    $sql = "CALL sp_restaurante_pedido_detalle(:id)";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows > 0) {
        $pedido = $resultado->fetch_assoc();

        // Ahora puedes mostrar los detalles del pedido en el HTML
        // Por ejemplo:
        echo "<h1>Detalles del Pedido</h1>";
        echo "<p>ID Pedido: " . $pedido['id'] . "</p>";
        echo "<p>Pedido Finalizado: " . $pedido['en_curso'] . "</p>";
        echo "<p>Fecha: " . $pedido['fecha'] . "</p>";
        echo "<p>Mesa: " . $pedido['nombre_mesa'] . "</p>";
        echo "<p>Precio Total: " . $pedido['precio_total'] . "</p>";

    } else {
        echo "No se encontró ningún pedido con el ID proporcionado.";
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    // Si no se proporcionó ningún ID de pedido, puedes mostrar un mensaje de error o redirigir al usuario a otra página.
    echo "No se proporcionó ningún ID de pedido.";
}
?>
