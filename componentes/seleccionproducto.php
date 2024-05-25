<div class="form-group">
    <label for="seleccionCat">Categoría</label>
    <select class="form-select" name="seleccionCat" id="seleccionCat" aria-label="Seleccionar Categoría" style="font-size: 18px;">
        <?php
        include "../../../modelo/conexion.php";
        $sql_categorias = "SELECT * FROM categoria";
        $result_categorias = $conexion->query($sql_categorias);

        if ($result_categorias->num_rows > 0) {
            while ($categoria = $result_categorias->fetch_assoc()) {
                echo "<optgroup label='" . $categoria['nombre'] . "'>";
                $sql_productos = "SELECT * FROM producto WHERE id_categoria = " . $categoria['id'];
                $result_productos = $conexion->query($sql_productos);

                if ($result_productos->num_rows > 0) {
                    while ($producto = $result_productos->fetch_assoc()) {
                        echo "<option value='" . $producto['id'] . "'>" . $producto['nombre'] . "</option>";
                    }
                }

                echo "</optgroup>";
            }
        }
        ?>
    </select>
</div>