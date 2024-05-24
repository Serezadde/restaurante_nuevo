<?php


require_once "conexion.php";
require_once "producto.php";


class Categoria{

    private $id;
    private $nombre;
    private $conexion;





    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    /*
    function obtenerListadoCategoria()
    {
        try {
            $querySelect = "SELECT * FROM categoria";
            $instanciaDB = $this->db->prepare($querySelect);

            $instanciaDB->execute();

            if ($instanciaDB) {
                return $instanciaDB->fetchAll(PDO::FETCH_CLASS, "Categoria");
            } else {
                echo "Ocurrió un error inesperado al obtener el Listado de Biblioteca";
            }
        } catch (Exception $ex) {
            echo "Ocurrió un error: " . $ex->getMessage();
            return null;
        }
    }
    */


    public function insertarCategoria($nombre) {
        try {
            $queryInsertar = "CALL sp_restaurante_categoria_insertar(?, @id)";
            $instanciaDB = $this->conexion->prepare($queryInsertar);

            if ($instanciaDB === false) {
                throw new Exception("Falló la preparación: " . $this->conexion->error);
            }

            $instanciaDB->bind_param('s', $nombre);

            if ($instanciaDB->execute()) {
                return true;
            } else {
                throw new Exception("Falló la ejecución: " . $instanciaDB->error);
            }
        } catch (Exception $ex) {
            return "Ocurrió un error: " . $ex->getMessage();
        }
    }


    public function eliminarCategoria($id) {
        try {
            $queryEliminar = "CALL sp_restaurante_categoria_eliminar(?)";
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

    public function editarCategoria($id, $nombre) {
        try {
            $queryEditar = "CALL sp_restaurante_categoria_editar(?, ?)";
            $instanciaDB = $this->conexion->prepare($queryEditar);

            if ($instanciaDB === false) {
                throw new Exception("Falló la preparación: " . $this->conexion->error);
            }

            $instanciaDB->bind_param('is', $id, $nombre);

            if ($instanciaDB->execute()) {
                return true;
            } else {
                throw new Exception("Falló la ejecución: " . $instanciaDB->error);
            }
        } catch (Exception $ex) {
            return "Ocurrió un error: " . $ex->getMessage();
        }
    }




    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre 
     * @return self
     */
    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id 
     * @return self
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }




}
