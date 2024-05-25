<?php
include "../../../modelo/conexion.php";
$sql = "CALL ObtenerMesasDisponibles()";
$result = $conexion->query($sql);
$mesas = [];

if ($result && $result->num_rows > 0) {
    while ($mesas_fetch = $result->fetch_assoc()) {
        $mesas[] = $mesas_fetch;
    }
}
if (!empty($mesas)) {
    //ponemos estas label aqui para que se visualice correctamente luego
    echo '<div class="form-group">';
    echo '<label for="seleccionMesa">Mesas</label>';
    echo '<select class="form-select" name="seleccionMesa" id="seleccionMesa" aria-label="Seleccionar Mesa" style="font-size: 18px;">';
    foreach ($mesas as $mesa) {
        echo "<option value='" . $mesa['id'] . "'>" . $mesa['nombre'] . "</option>";
    }
    echo '</select>';
    echo '</div>';
}
?>