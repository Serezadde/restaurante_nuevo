DELIMITER $$

CREATE PROCEDURE sp_restaurante_categoria_insertar(
    IN nombre VARCHAR(255),
   
    OUT id INT
)
BEGIN
    INSERT INTO categoria (nombre) 
    VALUES (nombre);
    
    SET id = LAST_INSERT_ID();
END $$

DELIMITER ;

