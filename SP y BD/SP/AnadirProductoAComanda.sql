DELIMITER $$

CREATE PROCEDURE AnadirProductoAComanda(IN id_comanda INT, IN id_producto INT, IN cantidad INT)
BEGIN
    INSERT INTO comanda_producto (id_comanda, id_producto, cantidad) VALUES (id_comanda, id_producto, cantidad);
END$$

DELIMITER ;