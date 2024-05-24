<!DOCTYPE html>
<html>
<?php
include "../../componentes/head.php";
include "../../modelo/util.php";
?>

<head>
    <title>Detalles del Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 16px; /* Ajusta el tamaño de la fuente del cuerpo */
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        h1 {
            text-align: center;
            font-size: 24px; /* Ajusta el tamaño de la fuente del título */
        }

        .details {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .details-column {
            flex-basis: 45%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .details-column h2 {
            margin-top: 0;
            font-size: 18px; /* Ajusta el tamaño de la fuente de los subtítulos */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            font-size: 16px; /* Ajusta el tamaño de la fuente de la tabla */
        }

        table th {
            background-color: #f2f2f2;
        }

        .btn {
            display: block;
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            font-size: 25px; 
        }

        .btn:hover {
            background-color: #0056b3;
        }
        .details p {
        font-size: 18px; /* Ajusta el tamaño de la fuente para los párrafos dentro de .details */
    }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/aec7d72014.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        <h1>Detalles del Pedido:</h1>
        <?php
        include "../../modelo/conexion.php";

        // Verificar si se ha proporcionado un ID de pedido en la URL
        if (isset($_GET['id'])) {
            $id_pedido = $_GET['id'];

            // Consulta SQL para obtener los detalles del pedido con el ID proporcionado
            $sql = "SELECT p.id AS id_pedido, p.en_curso, p.fecha, m.nombre AS nombre_mesa, SUM(pr.precio * cp.cantidad) AS precio_total
            FROM pedido p
            LEFT JOIN mesa m ON p.id_mesa = m.id
            LEFT JOIN comanda c ON p.id = c.id_pedido
            LEFT JOIN comanda_producto cp ON c.id = cp.id_comanda
            LEFT JOIN producto pr ON cp.id_producto = pr.id
            WHERE p.id = $id_pedido
            GROUP BY p.id";

            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                $fila = $resultado->fetch_assoc();
        ?>
                <div class="details">
                    <div class="details-column">
                        <h2>ID Pedido</h2>
                        <p><?php echo $fila["id_pedido"]; ?></p>
                    </div>

                    <div class="details-column">
                        <h2>Pedido Finalizado</h2>
                        <p><?php echo obtenerIcono($fila["en_curso"]); ?></p>
                    </div>

                    <div class="details-column">
                        <h2>Fecha</h2>
                        <p><?php echo $fila["fecha"]; ?></p>
                    </div>
                    <div class="details-column">
                        <h2>Mesa</h2>
                        <p><?php echo $fila["nombre_mesa"]; ?></p>
                    </div>
                    <div class="details-column">
                        <h2>Precio Total</h2>
                        <p><?php echo $fila["precio_total"]; ?>€ </p>
                    </div>
                </div>
        <?php
            } else {
                echo "No se encontró ningún pedido con el ID proporcionado.";
            }
        } else {
            echo "No se proporcionó ningún ID de pedido.";
        }
        ?>



        <h2>Productos:</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Unidades</th>
                    <th>Subtotal</th>

                </tr>
            </thead>
            <tbody>
                <?php
                include "../../modelo/conexion.php";



                $sql = $conexion->query("SELECT 
                producto.nombre AS Producto, 
                producto.precio AS Precio, 
                comanda_producto.cantidad AS Unidades, 
                (producto.precio * comanda_producto.cantidad) AS Subtotal
            FROM 
                producto
            INNER JOIN 
                comanda_producto ON producto.id = comanda_producto.id_producto
            INNER JOIN 
                comanda ON comanda.id = comanda_producto.id_comanda
            INNER JOIN 
                pedido ON pedido.id = comanda.id_pedido
            WHERE 
                pedido.id = $id_pedido");
                    while ($datos = $sql->fetch_object()) {
                        if (isset($_GET['id'])) {
                            $id_pedido = $_GET['id'];

                ?>
                        <tr>
                            <td><?= $datos->Producto ?></td>
                            <td><?= $datos->Precio ?></td>
                            <td><?= $datos->Unidades ?></td>
                            <td><?= $datos->Subtotal ?></td>

                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <a href="../Historial/historial.php"><button button class="btn btn-primary" style="font-size: 18px" >Atrás</button></a> 
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>