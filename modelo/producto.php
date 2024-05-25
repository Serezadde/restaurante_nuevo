<?php

require_once "conexion.php";
require_once "categoria.php";


class Producto
{

    private $conexion;



    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function eliminarProducto($id) {
        try {
            $queryEliminar = "CALL sp_restaurante_producto_eliminar(?)";
            $instanciaDB = $this->conexion->prepare($queryEliminar);

            if ($instanciaDB === false) {
                throw new Exception("Falló la preparación: " . $this->conexion->error);
            }

            $instanciaDB->bind_param('i', $id);

            if ($instanciaDB->execute()) {
                return true;
            } else {
                throw new Exception("Falló la ejecución: " . $instanciaDB->error);
            }
        } catch (Exception $ex) {
            return "Ocurrió un error: " . $ex->getMessage();
        }
    }



    public function editarProducto($id, $nombre, $precio, $id_categoria) {
        try {
            $queryEditar = "CALL sp_restaurante_producto_editar(?, ?, ?, ?)";
            $instanciaDB = $this->conexion->prepare($queryEditar);

            if ($instanciaDB === false) {
                throw new Exception("Falló la preparación: " . $this->conexion->error);
            }

            $instanciaDB->bind_param('isdi', $id, $nombre, $precio, $id_categoria);

            if ($instanciaDB->execute()) {
                return true;
            } else {
                throw new Exception("Falló la ejecución: " . $instanciaDB->error);
            }
        } catch (Exception $ex) {
            return "Ocurrió un error: " . $ex->getMessage();
        }
    }

    public function insertarProducto($nombre, $precio, $id_categoria) {
        try {
            $queryInsertar = "CALL sp_restaurante_producto_insertar(?, ?, ?)";
            $instanciaDB = $this->conexion->prepare($queryInsertar);

            if ($instanciaDB === false) {
                throw new Exception("Falló la preparación: " . $this->conexion->error);
            }

            $instanciaDB->bind_param('sdi', $nombre, $precio, $id_categoria);

            if ($instanciaDB->execute()) {
                return true;
            } else {
                throw new Exception("Falló la ejecución: " . $instanciaDB->error);
            }
        } catch (Exception $ex) {
            return "Ocurrió un error: " . $ex->getMessage();
        }
    }
}

