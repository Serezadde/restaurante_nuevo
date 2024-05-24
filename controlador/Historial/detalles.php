<?php
if(isset($_GET['id'])) {
    $id_pedido = $_GET['id'];
    $conexion = new mysqli("localhost", "root", "1111", "restaurante", "3306");
    $conexion->set_charset("utf8");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT p.*, m.nombre AS nombre_mesa, SUM(pr.precio * cp.cantidad) AS precio_total
            FROM pedido p
            LEFT JOIN mesa m ON p.id_mesa = m.id
            LEFT JOIN comanda c ON p.id = c.id_pedido
            LEFT JOIN comanda_producto cp ON c.id = cp.id_comanda
            LEFT JOIN producto pr ON cp.id_producto = pr.id
            WHERE p.id = $id_pedido
            GROUP BY p.id";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows > 0) {
        $pedido = $resultado->fetch_assoc();
        
        echo "<h1>Detalles del Pedido</h1>";
        echo "<p>ID Pedido: " . $pedido['id'] . "</p>";
        echo "<p>Pedido Finalizado: " . $pedido['en_curso'] . "</p>";
        echo "<p>Fecha: " . $pedido['fecha'] . "</p>";
        echo "<p>Mesa: " . $pedido['nombre_mesa'] . "</p>";
        echo "<p>Precio Total: " . $pedido['precio_total'] . "</p>";

    }
    else {
        echo "No se encontró ningún pedido con el ID proporcionado.";
    }

    $conexion->close();
}
else {
    
    echo "No se proporcionó ningún ID de pedido.";
}
?>
