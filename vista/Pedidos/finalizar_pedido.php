<!DOCTYPE html>
<html>
<head>
    <title>Finalizar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/aec7d72014.js" crossorigin="anonymous"></script>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: auto; }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center p-3">Finalizar Pedido</h1>

    <?php
    include "../../controlador/Pedido/pedido_finalizado.php";
    ?>

    <h2>Detalle del Pedido</h2>
    <p><strong>Mesa:</strong> <?= $pedido['nombre_mesa'] ?></p>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Unidades</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalle_comandas as $comanda) { ?>
                <tr>
                    <td><?= $comanda['nombre'] ?></td>
                    <td><?= $comanda['cantidad'] ?></td>
                    <td><?= $comanda['precio'] ?>€</td>
                    <td><?= $comanda['precio'] * $comanda['cantidad'] ?>€</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <h3>Total a Pagar: <?= $total ?>€</h3>

    <form method="post">
        <div class="mb-3">
            <label for="dinero_pagado" class="form-label">Dinero Pagado:</label>
            <input type="number" class="form-control" name="dinero_pagado" step="0.01">
        </div>
        <button type="submit" class="btn btn-primary" name="pagar_dinero">Pagar con Dinero</button>
        <button type="submit" class="btn btn-primary" name="pagar_tarjeta">Pagar con Tarjeta</button>
    </form>

    <?php if (isset($forma_pago)) { ?>
        <h3>Forma de Pago: <?= $forma_pago == 'dinero' ? 'Dinero' : 'Tarjeta' ?></h3>
        <h3>Total Pagado: <?= $pagado ?>€</h3>
        <h3>Devolución: <?= $devolucion ?>€</h3>
    <?php } ?>

    <!-- Formulario para finalizar el pedido -->
    <form method="post" action="../../controlador/Pedido/pedido_finalizado.php">
    <input type="hidden" name="id_pedido" value="<?= htmlspecialchars($_GET['id_pedido']) ?>">

        <input type="hidden" name="finalizar" value="1">
        <button type="submit" class="btn btn-success">Finalizar Pedido</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
