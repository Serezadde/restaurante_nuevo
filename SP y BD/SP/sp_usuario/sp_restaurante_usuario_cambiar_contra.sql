DELIMITER //

CREATE PROCEDURE sp_restaurante_usuario_verificar_contra(IN p_contrasena VARCHAR(255))
BEGIN
    DECLARE v_valido BOOLEAN DEFAULT FALSE;
    
    -- Verificar si la contraseña coincide con la registrada en la base de datos
    SELECT IF(COUNT(*) > 0, TRUE, FALSE) INTO v_valido
    FROM usuario
    WHERE password = p_contrasena;
    
    -- Devolver el resultado
    SELECT v_valido AS valido;
END//

DELIMITER ;