<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandas</title>

</head>
<body>


<h2>Añadir Nueva Comanda</h2>
<form action="" method="POST">
    <label for="mesa">Seleccionar Mesa Ocupada:</label>
    <select name="mesa" id="mesa" required>
        <?php while ($row = $mesas_ocupadas->fetch(PDO::FETCH_ASSOC)) : ?>
            <option value="<?php echo $row['id_pedido']; ?>"><?php echo $row['nombre']; ?></option>
        <?php endwhile; ?>
    </select><br>

    <!-- Lógica para añadir nueva comanda -->

    <input type="submit" value="Añadir Comanda">
</form>


</body>
</html>