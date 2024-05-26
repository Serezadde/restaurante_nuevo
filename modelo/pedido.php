<?php
class Pedido {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerPedido($id_pedido) {
        $query = "SELECT * FROM pedido WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('i', $id_pedido);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function finalizarPedido($id_pedido) {
        $sql = "CALL FinalizarPedido(?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
    }
    public function obtenerPedidoPorId($id_pedido) {
        $sql = "SELECT p.*, m.nombre as nombre_mesa 
                FROM pedido p
                JOIN mesa m ON p.id_mesa = m.id
                WHERE p.id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function obtenerPedidoPorMesa($id_mesa) {
        try {
            $query = "SELECT id FROM pedido WHERE id_mesa = ? AND en_curso = 'true'";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("i", $id_mesa);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['id'];
            } else {
                return false; // No se encontró ningún pedido en curso para la mesa
            }
        } catch (Exception $ex) {
            echo "Ocurrió un error: " . $ex->getMessage();
            return false;
        }
    }

function insertarPedido($precio, $en_curso, $fecha, $id_mesa) {
    global $pdo; // Suponiendo que $pdo es tu objeto PDO para la conexión

    try {
        // Preparar la llamada al procedimiento almacenado con los parámetros de entrada y salida
        $stmt = $pdo->prepare("CALL CrearPedido(:precio, :en_curso, :fecha, :id_mesa, @id)");
        
        // Vincular los parámetros de entrada
        $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
        $stmt->bindParam(':en_curso', $en_curso, PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':id_mesa', $id_mesa, PDO::PARAM_INT);
        
        // Ejecutar la consulta preparada
        $stmt->execute();
        
        // Recuperar el valor del ID del pedido generado por el procedimiento almacenado
        $stmt = $pdo->query("SELECT @id AS id");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_pedido = $result['id'];

        return $id_pedido; // Devolver el ID del pedido generado
    } catch (PDOException $e) {
        // Manejar cualquier error de la base de datos
        echo "Error al insertar el pedido: " . $e->getMessage();
    }
}
public function obtenerProductosPorPedido($id_pedido) {
    $productos = array();

    try {
        // Consulta SQL para obtener los productos asociados al pedido
        $sql = "SELECT producto.nombre, producto.precio, comanda_producto.cantidad, (producto.precio * comanda_producto.cantidad) AS subtotal
                FROM comanda_producto
                INNER JOIN producto ON comanda_producto.id_producto = producto.id
                WHERE comanda_producto.id_comanda IN (
                    SELECT comanda.id
                    FROM comanda
                    WHERE comanda.id_pedido = ?
                )";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
    } catch (Exception $ex) {
        echo "Ocurrió un error: " . $ex->getMessage();
    }

    return $productos;
}



}



?>
