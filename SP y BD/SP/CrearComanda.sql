DELIMITER $$

CREATE PROCEDURE CrearComanda(IN id_pedido INT)
BEGIN
    INSERT INTO comanda (id_pedido) VALUES (id_pedido);
END$$

DELIMITER ;