<!DOCTYPE html>
<html>
<head>
    <title>Agregar Comanda al Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: auto; }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center p-3">Agregar Comanda al Pedido</h1>

    <h2>Mesa: <?= $pedido_mesa['nombre_mesa'] ?></h2>
    <h3>Pedido ID: <?= $pedido_mesa['id_pedido'] ?></h3>

    <form method="post">
        <div class="mb-3">
            <label for="id_producto" class="form-label">Seleccionar Producto:</label>
            <select class="form-select" name="id_producto">
                <?php foreach ($productos as $producto) { ?>
                    <option value="<?= $producto['id'] ?>"><?= $producto['nombre'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad:</label>
            <input type="number" class="form-control" name="cantidad" required>
        </div>
        <button type="submit" class="btn btn-primary" name="guardar_comanda">Guardar Comanda</button>
    </form>

    <h2>Comandas del Pedido:</h2>
    <ul>
        <?php foreach ($comandas_pedido as $comanda) { ?>
            <li>Producto: <?= $comanda['nombre_producto'] ?> - Cantidad: <?= $comanda['cantidad'] ?></li>
        <?php } ?>
    </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
