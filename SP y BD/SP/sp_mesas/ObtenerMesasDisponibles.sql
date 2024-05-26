DELIMITER $$

CREATE PROCEDURE ObtenerMesasDisponibles()
BEGIN
    SELECT id, nombre
    FROM mesa
    WHERE id NOT IN (SELECT id_mesa FROM pedido WHERE en_curso = 'true');
END$$

DELIMITER ;