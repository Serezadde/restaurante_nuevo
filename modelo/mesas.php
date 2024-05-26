<?php

require_once "conexion.php";
class Mesas {
    private $conexion;
    private $id;
    private $nombre;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertarMesa($nombre) {
        try {
            $queryInsertar = "CALL sp_restaurante_mesa_insertar(?)";
            $instanciaDB = $this->conexion->prepare($queryInsertar);

            if ($instanciaDB === false) {
                throw new Exception("Falló la preparación: " . $this->conexion->error);
            }

            $instanciaDB->bind_param('s', $nombre);

            if ($instanciaDB->execute()) {
                $nuevo_id = $this->conexion->insert_id;
                return array('success' => true, 'mensaje' => 'Mesa creada correctamente, ID: ' . $nuevo_id);
            } else {
                throw new Exception("Falló la ejecución: " . $instanciaDB->error);
            }
        } catch (Exception $ex) {
            return array('success' => false, 'mensaje' => 'Error al registrar: ' . $ex->getMessage());
        }
    }

    public function editarMesa($id, $nombre) {
        try {
            $queryEditar = "CALL sp_restaurante_mesa_editar(?, ?)";
            $instanciaDB = $this->conexion->prepare($queryEditar);

            if ($instanciaDB === false) {
                throw new Exception("Falló la preparación: " . $this->conexion->error);
            }

            $instanciaDB->bind_param('is', $id, $nombre);

            if ($instanciaDB->execute()) {
                return array('success' => true, 'mensaje' => 'Mesa editada correctamente');
            } else {
                throw new Exception("Falló la ejecución: " . $instanciaDB->error);
            }
        } catch (Exception $ex) {
            return array('success' => false, 'mensaje' => 'Error al editar: ' . $ex->getMessage());
        }
    }


    public function eliminarMesa($id) {
        try {
            $queryEliminar = "CALL sp_restaurante_mesa_eliminar(?)";
            $instanciaDB = $this->conexion->prepare($queryEliminar);

            if ($instanciaDB === false) {
                throw new Exception("Falló la preparación: " . $this->conexion->error);
            }

            $instanciaDB->bind_param('i', $id);

            if ($instanciaDB->execute()) {
                return array('success' => true, 'mensaje' => 'Mesa eliminada correctamente');
            } else {
                throw new Exception("Falló la ejecución: " . $instanciaDB->error);
            }
        } catch (Exception $ex) {
            return array('success' => false, 'mensaje' => 'Error al eliminar la mesa: ' . $ex->getMessage());
        }
    }

    /*
    public function obtenerMesasOcupadas() {
        try {
            $query = "SELECT * FROM mesa WHERE id IN (SELECT DISTINCT id_mesa FROM pedido WHERE en_curso = 'true')";
            $result = $this->conexion->query($query);
            $mesas = [];
            while ($row = $result->fetch_assoc()) {
                $mesas[] = $row;
            }
            return $mesas;
        } catch (Exception $ex) {
            echo "Ocurrió un error: " . $ex->getMessage();
            return [];
        }
    }
    */





    public function getId()
    {
        return $this->id;
    }
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }



}


?>