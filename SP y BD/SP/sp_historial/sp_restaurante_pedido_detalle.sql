DELIMITER //

CREATE PROCEDURE sp_restaurante_pedido_detalle(IN pedido_id INT)
BEGIN
    SELECT p.*, m.nombre AS nombre_mesa, SUM(pr.precio * cp.cantidad) AS precio_total
    FROM pedido p
    LEFT JOIN mesa m ON p.id_mesa = m.id
    LEFT JOIN comanda c ON p.id = c.id_pedido
    LEFT JOIN comanda_producto cp ON c.id = cp.id_comanda
    LEFT JOIN producto pr ON cp.id_producto = pr.id
    WHERE p.id = pedido_id
    GROUP BY p.id;
END //

DELIMITER ;

/*
DELIMITER //

CREATE PROCEDURE sp_restaurante_pedido_detalle(IN pedido_id INT)
BEGIN
    DECLARE total_pedido DECIMAL(10,2);

    -- Obtener los detalles del pedido
    SELECT p.id AS pedido_id, p.fecha, m.nombre AS nombre_mesa
    FROM pedido p
    LEFT JOIN mesa m ON p.id_mesa = m.id
    WHERE p.id = pedido_id
    INTO @pedido_id, @fecha, @nombre_mesa;

    -- Llamar al procedimiento almacenado para calcular el precio total del pedido
    CALL CalcularPrecioFinalPedidoConCursor(pedido_id, total_pedido);

    -- Devolver los detalles del pedido junto con el precio total
    SELECT @pedido_id AS id_pedido, @fecha AS fecha, @nombre_mesa AS nombre_mesa, total_pedido AS precio_total;
END //

DELIMITER ;

*/