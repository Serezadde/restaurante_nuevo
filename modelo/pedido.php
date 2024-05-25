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
        $sql = "UPDATE pedido SET en_curso = 'false' WHERE id = ?";
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
}



?>
