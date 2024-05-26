<div class="form-group">
    <label for="seleccionProd">Producto</label>
    <select class="form-select" name="seleccionProd" id="seleccionProd" aria-label="Seleccionar Producto" style="font-size: 18px;">
        <?php
        include "../../../modelo/conexion.php";

        $categoria_id = isset($_SESSION['categoria_id']) ? $_SESSION['categoria_id'] : '';
        if (!empty($categoria_id)) {
            $sql = "SELECT id, nombre, precio FROM producto WHERE id_categoria = ?";
            $statement = $conexion->prepare($sql);
            $statement->bind_param("i", $categoria_id);
            $statement->execute();
            $result = $statement->get_result();
            if ($result->num_rows > 0) {
                while ($producto = $result->fetch_assoc()) {
                    echo "<option value='" . $producto['id'] . "'>" . $producto['nombre'] . "</option>";
                }
            }
        }
        ?>
    </select>
</div>