<!DOCTYPE html>
<html>
<head>
    <title>Seleccionar Mesa Ocupada</title>
</head>
<body>
    <h2>Seleccionar Mesa Ocupada</h2>
    <form method="post" action="../../controlador/Pedido/mesas_ocupadas.php">
        <?php
        include "../../modelo/conexion.php";
        $sql = "CALL ObtenerMesasOcupadas()";
        $result = $conexion->query($sql);
        $mesas = [];

        if ($result && $result->num_rows > 0) {
            echo '<div class="form-group">';
            echo '<label for="seleccionMesa">Mesas</label>';
            echo '<select class="form-select" name="seleccionMesa" id="seleccionMesa" aria-label="Seleccionar Mesa" style="font-size: 18px;">';
            while ($mesas_fetch = $result->fetch_assoc()) {
                $mesas[] = $mesas_fetch;
                echo "<option value='" . $mesas_fetch['id'] . "'>" . $mesas_fetch['nombre'] . "</option>";
            }
            echo '</select>';
            echo '</div>';
        } else {
            echo "No hay mesas ocupadas disponibles.";
        }
        ?>
        <br>
        <input type="submit" value="Seleccionar Mesa">

    </form>
</body>
</html>