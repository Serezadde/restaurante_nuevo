<?php
class Comanda {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerComandas() {
        $query = "SELECT c.*, p.nombre AS producto_nombre, ped.nombre AS pedido_nombre 
                  FROM comanda c 
                  JOIN producto p ON c.id_producto = p.id 
                  JOIN pedido ped ON c.id_pedido = ped.id";
        $result = $this->conexion->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerComanda($id) {
        $query = "SELECT * FROM comanda WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function crearComanda($id_pedido, $id_producto, $unidades) {
        $query = "INSERT INTO comanda (id_pedido, id_producto, unidades) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('iii', $id_pedido, $id_producto, $unidades);
        return $stmt->execute();
    }

    public function actualizarComanda($id, $id_pedido, $id_producto, $unidades) {
        $query = "UPDATE comanda SET id_pedido = ?, id_producto = ?, unidades = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('iiii', $id_pedido, $id_producto, $unidades, $id);
        return $stmt->execute();
    }

    public function eliminarComanda($id) {
        $query = "DELETE FROM comanda WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
    public function obtenerComandasPorPedido($id_pedido) {
        $sql = "SELECT cp.*, p.nombre, p.precio 
                FROM comanda c
                JOIN comanda_producto cp ON c.id = cp.id_comanda
                JOIN producto p ON cp.id_producto = p.id
                WHERE c.id_pedido = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function agregarComanda($id_pedido, $id_producto, $cantidad) {
        try {
            // Preparar la consulta para insertar la nueva comanda
            $query = "INSERT INTO comanda_producto (id_comanda, id_producto, cantidad) VALUES (?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
    
            // Vincular los parámetros
            $stmt->bind_param("iii", $id_pedido, $id_producto, $cantidad);
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Verificar si la inserción fue exitosa
            if ($stmt->affected_rows > 0) {
                // La comanda se agregó correctamente
                return true;
            } else {
                // La inserción falló
                return false;
            }
        } catch (Exception $ex) {
            // Ocurrió un error durante la ejecución de la consulta
            echo "Ocurrió un error: " . $ex->getMessage();
            return false;
        }
    }
    
}


?>
