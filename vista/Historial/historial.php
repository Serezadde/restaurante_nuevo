<!DOCTYPE html>
<html>
<?php
include "../../componentes/head.php";
include "../../modelo/util.php";
?>
<head>
    <title>Historial de Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px; /* Aumenta el tamaño de la fuente del cuerpo */
        }
        h2 {
            font-size: 24px; /* Aumenta el tamaño de los encabezados */
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        .table-container {
            margin: auto;
            width: 80%;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            font-size: 18px; /* Aumenta el tamaño de los botones */
            padding: 10px 20px;
            margin: 10px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
     <script src="https://kit.fontawesome.com/aec7d72014.js" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
        <h2>Historial de Pedidos:</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Precio</th>
                    <th>En curso</th>
                    <th>Fecha</th>
                    <th>Mesa</th>
                    <th>Detalles</th>
                </tr>
                <tbody>
          <?php
          include "../../modelo/conexion.php";
          $sql = $conexion->query("SELECT * FROM pedido");
          while ($datos = $sql->fetch_object()) {
          ?>
            <tr>
              <td><?= $datos->id ?></td>
              <td><?= $datos->precio ?> €</td>
              <td><?= obtenerIcono($datos->en_curso) ?></td>
              <td><?= $datos->fecha ?></td>
              <td><?= $datos->id_mesa ?></td>
              <td><a href="detalles.php?id=<?= $datos->id ?>" class="btn btn-small btn-success"><i class="fa-solid fa-eye"></i></a></td>

            </tr>
          <?php
          }
          ?>
        </tbody>
            </table>
        </div>
              <a href="../Administracion/administración_menu.php"><button button class="btn btn-primary">Atrás</button></a>
    </div>
</body>
</html>
