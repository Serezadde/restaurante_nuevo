<?php

require_once "bd.php";


class Usuario
{
    private $db;
    private $id;
    private $nombre;
    private $password;
    private $disponible;
    private $nuevaContrasena;
    private $repetirContrasena;
    private $contrasenaActual;






    function __construct()
    {
        $bd = new bd();
        $this->db = $bd->conectarBD();
    }

 




    function guardar()
    {
        // Preparar la sentencia SQL para insertar o actualizar el usuario en la base de datos
        if ($this->id) {
            // Si el usuario ya tiene un ID, actualizar los datos
            $sql = "UPDATE usuario SET nombre=?, password=?, disponible=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam("ssii", $this->nombre, $this->password, $this->disponible, $this->id);
        } else {
            // Si es un nuevo usuario, insertar los datos
            $sql = "INSERT INTO usuario (nombre, password, disponible) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam("ssi", $this->nombre, $this->password, $this->disponible);
        }

        // Ejecutar la consulta preparada
        if ($stmt->execute()) {
            return true; // La operación de guardado fue exitosa
        } else {
            return false; // Hubo un error al guardar el usuario
        }
    }



    function cambiarContrasena($nuevaContrasena)
    {
        // Encriptar la nueva contraseña antes de guardarla en la base de datos
        $this->password = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

        // Llamar al método guardar para actualizar la contraseña en la base de datos
        return $this->guardar();
    }



    function obtenerPorId($idUsuario)
    {
        // Preparar la sentencia SQL para obtener el usuario por su ID
        $sql = "SELECT * FROM usuario WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $idUsuario, PDO::PARAM_INT);

        // Ejecutar la consulta preparada
        $stmt->execute();

        // Vincular las columnas de resultado a variables
        $stmt->bindColumn('id', $idUsuario);
        $stmt->bindColumn('nombre', $nombre);
        $stmt->bindColumn('password', $password);
        $stmt->bindColumn('disponible', $disponible);

        // Obtener los resultados de la consulta
        $resultados = array();
        while ($stmt->fetch(PDO::FETCH_BOUND)) {
            // Crear un nuevo objeto Usuario con los datos obtenidos
            $usuario = new Usuario();
            $usuario->setId($idUsuario);
            $usuario->setNombre($nombre);
            $usuario->setPassword($password);
            $usuario->setDisponible($disponible);

            // Agregar el usuario al array de resultados
            $resultados[] = $usuario;
        }

        // Devolver el array de usuarios encontrados
        return $resultados;
    }



    // Función para verificar las credenciales del usuario
    function verificarCredenciales()
    {
        try {
            $querySelect = "SELECT * FROM usuario WHERE nombre = :nombre AND password = :password";
            $instanciaDB = $this->db->prepare($querySelect);
            $instanciaDB->bindParam(":nombre", $this->nombre);
            $instanciaDB->bindParam(":password", $this->password);
            $instanciaDB->execute();
    
            // Verificar si se encontró al menos una fila de resultados
            $usuario = $instanciaDB->fetch(PDO::FETCH_ASSOC);
    
            if ($usuario) {
                return true; // Credenciales válidas
            } else {
                return false; // Credenciales inválidas
            }
        } catch (PDOException $ex) {
            echo "Ocurrió un error: " . $ex->getMessage();
            return false;
        }
    }
    










    function obtenerUsuarios()
    {
        try {
            $querySelect = "SELECT * FROM usuario WHERE id = :idusuario";

            $instanciaDB = $this->db->prepare($querySelect);
            $instanciaDB->bindParam(":idusuario", $this->id);
            $instanciaDB->execute();

            // Verificar si se encontraron resultados
            $usuario = $instanciaDB->fetch(PDO::FETCH_OBJ);
            if ($usuario) {
                return $usuario;
            } else {
                echo "No se encontró ningún usuario con el ID especificado.";
                return null;
            }
        } catch (PDOException $ex) {
            echo "Ocurrió un error: " . $ex->getMessage();
            return null;
        }
    }


    function actualizarUsuarios($contrasenaActual, $nuevaContrasena, $repetirContrasena)
{
    try {
        // Verificar si las contraseñas nueva y repetida coinciden
        if ($nuevaContrasena !== $repetirContrasena) {
            return "Las contraseñas nueva y repetida no coinciden";
        }


        // Actualizar la contraseña en la base de datos
        $queryUpdate = "UPDATE usuario SET password = :password WHERE password = :contrasenaActual";
        $instanciaDB = $this->db->prepare($queryUpdate);
        $instanciaDB->bindParam(":password", $nuevaContrasena);
        $instanciaDB->bindParam(":contrasenaActual", $contrasenaActual);
        $instanciaDB->execute();

        if ($instanciaDB->rowCount() > 0) {
             echo '<div class="alert alert-success">Contraseña actualizada correctamente</div>';
        } else {
            echo '<div class="alert alert-warning">La contraseña actual no coincide con la registrada en la base de datos</div>';
      }
    } catch (Exception $ex) {
        // Manejar errores aquí 
        echo '<div class="alert alert-warning">Ocurrió un error al actualizar la contraseña</div>';
  
    }
}

    
    











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

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getDisponible()
    {
        return $this->disponible;
    }
    public function setDisponible($disponible): self
    {
        $this->disponible = $disponible;
        return $this;
    }
}
