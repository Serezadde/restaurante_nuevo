<?php
$mesas = [];
$sql = "SELECT id, nombre FROM mesa";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mesas[] = $row;
    }
}
?>
<div class="form-group">
    <label for="mesaSelect">Seleccionar Mesa</label>
    <select class="form-select" name="id" id="mesaSelect" required>
        <?php foreach ($mesas as $mesa) { ?>
            <option value="<?= $mesa['id'] ?>"><?= $mesa['nombre'] ?></option>
        <?php } ?>
    </select>
</div>