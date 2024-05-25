<div class="form-group">
    <label for="seleccionCat">Categoría</label>
    <select class="form-select" name="seleccionCat" id="seleccionCat" aria-label="Seleccionar Categoría" style="font-size: 18px;">        <?php
        include "../../../modelo/conexion.php";
        $sql = "SELECT * FROM categoria";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            while ($categoria = $result->fetch_assoc()) {
                echo "<option value='" . $categoria['id'] . "'>" . $categoria['nombre'] . "</option>";
            }
        }
        ?>
    </select>
</div>
