DELIMITER //

CREATE PROCEDURE sp_restaurante_producto_insertar(
    IN nombre_producto VARCHAR(255),
    IN precio_producto DECIMAL(10, 2),
    IN id_categoria_producto INT
)
BEGIN
    INSERT INTO producto(nombre, precio, id_categoria)
    VALUES (nombre_producto, precio_producto, id_categoria_producto);
END //

DELIMITER ;