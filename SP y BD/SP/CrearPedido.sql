DELIMITER $$

CREATE PROCEDURE CrearPedido(IN precio FLOAT, IN en_curso VARCHAR(5), IN fecha DATE, IN id_mesa INT)
BEGIN
    INSERT INTO pedido (precio, en_curso, fecha, id_mesa) VALUES (precio, en_curso, fecha, id_mesa);
END$$

DELIMITER ;
