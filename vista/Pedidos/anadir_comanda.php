<!DOCTYPE html>
<html>

<?php
include "../../componentes/head.php";
include "../../modelo/conexion.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mesa_id = $_GET["id"];
$categoria_id = isset($_POST['seleccionCat']) ? $_POST['seleccionCat'] : (isset($_SESSION['categoria_id']) ? $_SESSION['categoria_id'] : '');
if (isset($_POST['seleccionCat'])) {
    $_SESSION['categoria_id'] = $_POST['seleccionCat'];
}
?>

<head>
  <title>Añadir comanda a pedido</title>
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
  <div class="container-fluid row">
    <div class="col-md-4">
      <h2 class="text-left p-3">Añadir comanda a pedido</h2>
      <form name="CategoriaForm" method="post" action="">
        
        <!-- categorias -->
        <div>
          <?php include "../../componentes/seleccioncategoria.php"; ?>
        </div>
      </form>

      <form name="ProductoForm" method="post" action="../../controlador/Gestion/Producto/anadir_producto_comanda.php">
        <!-- productos -->
        <div>
          <?php include "../../componentes/seleccionproducto.php"; ?>
        </div>
        <input type="hidden" name="mesa_id" value="<?= htmlspecialchars($mesa_id) ?>">
        <button type="submit" class="btn btn-primary" name="btnAnadir" value="okAnadir">Añadir Producto</button>
      </form>
    </div>
    <div class="col-md-8">
      <h3>Lista de Productos</h3>
      <table class="table" id="productosTable">
        <thead>
          <tr>
            <th scope="col">Producto</th>
            <th scope="col">Precio</th>
            <th scope="col">Unidades</th>
            <th scope="col">Subtotal</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($_SESSION['productos']) && count($_SESSION['productos']) > 0) {
              //recorremos cada fila de la tabla de productos, siempre y cuando no esté vacía
              foreach ($_SESSION['productos'] as $producto) {
                //añadimos los botones + (verde), - (rojo), eliminar y guardar
                // ambos llamarán a modificar_cantidad.php para sumar o restar las unidades
                  echo "<tr>
                          <td>" . htmlspecialchars($producto['nombre']) . "</td>
                          <td>" . htmlspecialchars($producto['precio']) . "€</td>
                          <td>" . htmlspecialchars($producto['unidades']) . "</td>
                          <td>" . htmlspecialchars($producto['subtotal']) . "€</td>
                          <td>
                              <form method='post' action='../../controlador/Gestion/Producto/modificar_cantidad_comanda.php' style='display:inline;'>
                                  <input type='hidden' name='producto_id' value='" . $producto['id'] . "'>
                                  <input type='hidden' name='mesa_id' value='" . $mesa_id . "'>
                                  <input type='hidden' name='accion' value='incrementar'>
                                  <button type='submit' class='btn btn-success btn-sm'>+</button>
                              </form>
                              <form method='post' action='../../controlador/Gestion/Producto/modificar_cantidad_comanda.php' style='display:inline;'>
                                  <input type='hidden' name='producto_id' value='" . $producto['id'] . "'>
                                  <input type='hidden' name='mesa_id' value='" . $mesa_id . "'>
                                  <input type='hidden' name='accion' value='disminuir'>
                                  <button type='submit' class='btn btn-danger btn-sm'>-</button>
                              </form>
                              <form method='post' action='../../controlador/Gestion/Producto/eliminar_producto_de_tabla_comanda.php' style='display:inline;'>
                                  <input type='hidden' name='producto_id' value='" . $producto['id'] . "'>
                                  <input type='hidden' name='mesa_id' value='" . $mesa_id . "'>
                                  <button type='submit' class='btn btn-danger btn-sm'>Eliminar</button>
                              </form>
                          </td>
                        </tr>";
              }
          }
          ?>
        </tbody>
      </table>
      <form method="post" action="../../controlador/Gestion/Producto/guardar_comanda.php">
        <input type="hidden" name="mesa_id" value="<?= htmlspecialchars($mesa_id) ?>">
        <button type="submit" class="btn btn-primary" name="btnComanda" value="okComanda">Guardar</button>
      </form>
    </div>
  </div>
  <footer>
    <a href="../../vista/Pedidos/menu.php"><button class="btn btn-primary">Atrás</button></a>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>