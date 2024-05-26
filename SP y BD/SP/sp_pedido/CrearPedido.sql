DELIMITER $$

CREATE PROCEDURE CrearPedido(
    IN precio FLOAT, 
    IN en_curso VARCHAR(5), 
    IN fecha DATE, 
    IN id_mesa INT
)
BEGIN
    DECLARE id INT;

    INSERT INTO pedido (precio, en_curso, fecha, id_mesa) 
    VALUES (precio, en_curso, fecha, id_mesa);
    
    SET id = LAST_INSERT_ID();
    
    SELECT id AS last_id;
END$$

DELIMITER ;
