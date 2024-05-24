<!DOCTYPE html>
<html>

<?php
include "../../componentes/head.php";
include "../../modelo/conexion.php";
$id = $_GET["id"];
?>

<head>
  <title>Nuevo pedido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/aec7d72014.js" crossorigin="anonymous"></script>
  <style>
    body { font-family: Arial, sans-serif; font-size: 16px; }
    tbody tr { cursor: pointer; }
    .form-label, .form-control { font-size: 17px; }
    .btn { font-size: 17px; }
    #productosTable th, #productosTable td { font-size: 17px; }
  </style>
</head>
<body>
  <h1 class="text-center p-3">Productos:</h1>
  <script>
    function eliminar() {
      var respuesta = confirm("¿Estás seguro que quieres eliminar?");
      return respuesta;
    }
  </script>
  <?php
  include "../../modelo/conexion.php";
  ?>
  <div class="container-fluid row">
    <div class="col-md-4">
      <h2 class="text-left p-3">Nuevo Pedido</h2>
      <form name="CrearProdForm" method="post" action="../../controlador/Gestion/Producto/crear.php">
        
        <!-- categorias -->
        <div>
          <?php include "../../componentes/seleccioncategoria.php"; ?>
        </div>

        <!-- productos -->
        <div>
          <?php include "../../componentes/seleccionproducto.php"; ?>
        </div>

        <button type="submit" class="btn btn-primary" name="btncrear" value="okcrear">Crear</button>
      </form>
    </div>
    <div class="col-md-8">
      <table class="table" id="productosTable">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Precio</th>
            <th scope="col">Categoria</th>
            <th scope="col">Operaciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = $conexion->query("SELECT p.*, c.nombre AS categoria FROM producto p JOIN categoria c ON p.id_categoria = c.id");
          while ($datos = $sql->fetch_object()) {
          ?>
            <tr>
              <td><?= $datos->id ?></td>
              <td><?= $datos->nombre ?></td>
              <td><?= $datos->precio ?>€</td>
              <td><?= $datos->categoria ?></td>
              <td>
                <a href="../../../vista/Gestion/Producto/editar_prod.php?id=<?= $datos->id ?>" class="btn btn-small btn-warning">Editar <i class="fa-solid fa-pen-to-square"></i></a>
                <a onclick="return eliminar()" href="../../controlador/Gestion/Producto/eliminar.php?id=<?= $datos->id ?>" class="btn btn-small btn-danger">Borrar <i class="fa-solid fa-trash"></i></a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <footer>
    <a href="../../Administracion/administración_menu.php"><button class="btn btn-primary">Atrás</button></a>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>