DELIMITER $$

CREATE PROCEDURE `FinalizarPedido`(IN pedido_id INT)
BEGIN
    UPDATE pedido
    SET en_curso = 'false'
    WHERE id = pedido_id;
END$$

DELIMITER ;