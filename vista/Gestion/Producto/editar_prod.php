<?php
include "../../../modelo/conexion.php";
$id = $_GET["id"];

$id = intval($id);

$result = $conexion->query("SELECT * FROM producto WHERE id=$id");

if (!$result) {
    
    echo "Error: " . $conexion->error;
} else {
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EditarPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

    <h1 class="text-center p-3">Editar Productos:</h1>

    <form class="col-4 p-3 m-auto" name="editarProdForm" method="post">
        <input type="text" name="id" value="<?= $_GET["id"] ?>" readonly>

        <?php
        include "../../../controlador/Gestion/Producto/editar.php";
        while ($datos = $result->fetch_object()) { ?>
        
            <div class="mb-3">
                <label for="exampleInputeditar" class="form-label">Editar Producto:</label>
                <input type="text" class="form-control" name="nombre" value="<?= $datos->nombre ?>">
            </div>
            <div class="mb-3">
  <label for="exampleInputPrecio" class="form-label">Precio del producto:</label>
  <input type="number" class="form-control" name="precio" step="0.01">
</div>
            <div >
        <?php
       include "../../../componentes/seleccioncategoria.php";
            
        }
        ?>
        </div >
<br>
        <button type="submit" class="btn btn-primary" name="btneditar" value="okeditar">editar</button>
    </form>

</body>

</html>
<?php
} 
?>