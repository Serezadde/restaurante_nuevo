--Usuario

--Editar

DELIMITER //

CREATE PROCEDURE sp_restaurante_usuario_editar(
    IN p_id INT,
    IN p_nombre VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_disponible TINYINT(1)
)
BEGIN
    UPDATE usuario
    SET nombre = p_nombre,
        password = p_password,
        disponible = p_disponible
    WHERE id = p_id;
END //

DELIMITER ;

--Insertar

DELIMITER //

CREATE PROCEDURE sp_restaurante_usuario_insertar(
    IN p_nombre VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_disponible TINYINT(1)
)
BEGIN
    INSERT INTO usuario (nombre, password, disponible)
    VALUES (p_nombre, p_password, p_disponible);
END //

DELIMITER ;

--Verificar credenciales:

DELIMITER //

CREATE PROCEDURE sp_restaurante_usuario_verificar_credenciales(
    IN p_nombre VARCHAR(255),
    IN p_password VARCHAR(255)
)
BEGIN
    DECLARE v_existe INT;
    
    SELECT COUNT(*)
    INTO v_existe
    FROM usuario
    WHERE nombre = p_nombre AND password = p_password;

    IF v_existe > 0 THEN
        SELECT 'true' AS resultado;
    ELSE
        SELECT 'false' AS resultado;
    END IF;
END //

DELIMITER ;

--cambiar contra

DELIMITER //

CREATE PROCEDURE sp_restaurante_usuario_verificar_contra(IN p_contrasena VARCHAR(255))
BEGIN
    DECLARE v_valido BOOLEAN DEFAULT FALSE;

    SELECT IF(COUNT(*) > 0, TRUE, FALSE) INTO v_valido
    FROM usuario
    WHERE password = p_contrasena;

    SELECT v_valido AS valido;
END//

DELIMITER ;

--Categoria

--Insertar
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

--Seleccionar

DELIMITER $$

CREATE PROCEDURE sp_restaurante_categoria_seleccionar ()
BEGIN
    SELECT * FROM categoria;
END $$

DELIMITER ;

--Editar
DELIMITER //

CREATE PROCEDURE sp_restaurante_categoria_editar(
    IN categoria_id INT,
    IN nuevo_nombre VARCHAR(255)
)
BEGIN
    UPDATE categoria SET nombre = nuevo_nombre WHERE id = categoria_id;
END //

DELIMITER ;

--Eliminar

DELIMITER //

CREATE PROCEDURE sp_restaurante_categoria_eliminar(
    IN categoria_id INT
)
BEGIN
    DELETE FROM categoria WHERE id = categoria_id;
END //

DELIMITER ;

--Producto

--Insertar
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

--Actualizar
DELIMITER //

CREATE PROCEDURE sp_restaurante_producto_editar(
    IN producto_id INT,
    IN producto_nombre VARCHAR(255),
    IN producto_precio DECIMAL(10,2),
    IN producto_id_categoria INT
)
BEGIN
    UPDATE producto
    SET nombre = producto_nombre, precio = producto_precio, id_categoria = producto_id_categoria
    WHERE id = producto_id;
END //

DELIMITER ;
--Borrar
DELIMITER //

CREATE PROCEDURE sp_restaurante_producto_eliminar(
    IN producto_id INT
)
BEGIN
    DELETE FROM producto WHERE id = producto_id;
END //

DELIMITER ;

--Seleccionar


--Mesas

--Insertar
DELIMITER //

CREATE PROCEDURE sp_restaurante_mesa_insertar(
    IN mesa_nombre VARCHAR(255)
)
BEGIN
    INSERT INTO mesa(nombre) VALUES (mesa_nombre);
END //

DELIMITER ;

--Editar

DELIMITER //

CREATE PROCEDURE sp_restaurante_mesa_editar(
    IN mesa_id INT,
    IN mesa_nombre VARCHAR(255)
)
BEGIN
    UPDATE mesa
    SET nombre = mesa_nombre
    WHERE id = mesa_id;
END //

DELIMITER ;

--Eliminar

DELIMITER //

CREATE PROCEDURE sp_restaurante_mesa_eliminar(
    IN mesa_id INT
)
BEGIN
    DELETE FROM mesa WHERE id = mesa_id;
END //

DELIMITER ;

--Seleccionar

DELIMITER //

CREATE PROCEDURE sp_restaurante_mesa_seleccionar(
)
BEGIN
    SELECT * FROM mesa;
END //

DELIMITER ;

--Sin ordenar

DELIMITER $$

CREATE TRIGGER `AfterPedidoFinalizadoInsertHistorico`
AFTER UPDATE ON `pedido`
FOR EACH ROW
BEGIN
    IF OLD.en_curso = 'true' AND NEW.en_curso = 'false' THEN
        INSERT INTO `pedido_historico` (`pedido_id`, `precio`, `en_curso`, `fecha`, `id_mesa`, `fecha_registro`)
        VALUES (NEW.id, NEW.precio, NEW.en_curso, NEW.fecha, NEW.id_mesa, NOW());
    END IF;
END$$

DELIMITER ;

----

DELIMITER $$

CREATE PROCEDURE AnadirProductoAComanda(IN id_comanda INT, IN id_producto INT, IN cantidad INT)
BEGIN
    INSERT INTO comanda_producto (id_comanda, id_producto, cantidad) VALUES (id_comanda, id_producto, cantidad);
END$$

DELIMITER ;

--Historial

DELIMITER //

CREATE PROCEDURE sp_restaurante_obtener_historial_pedidos()
BEGIN
    SELECT * FROM pedido;
END //

DELIMITER ;

--Primera parte de detalles del pedido
DELIMITER //

CREATE PROCEDURE sp_restaurante_pedido_detalle(IN pedido_id INT)
BEGIN
    DECLARE total_pedido DECIMAL(10,2);
    DECLARE v_pedido_id INT;
    DECLARE v_en_curso VARCHAR(5);
    DECLARE v_fecha DATE;
    DECLARE v_nombre_mesa VARCHAR(255);

    SELECT p.id, p.en_curso, p.fecha, m.nombre
    INTO v_pedido_id, v_en_curso, v_fecha, v_nombre_mesa
    FROM pedido p
    LEFT JOIN mesa m ON p.id_mesa = m.id
    WHERE p.id = pedido_id;

    CALL CalcularPrecioFinalPedidoConCursor(pedido_id, total_pedido);

    SELECT v_pedido_id AS id_pedido, v_en_curso AS en_curso, v_fecha AS fecha, v_nombre_mesa AS nombre_mesa, total_pedido AS precio_total;
END //

DELIMITER ;

--segunda parte de detalles del pedido, para los productos



DELIMITER $$

CREATE PROCEDURE `sp_restaurante_obtener_productos_pedido` (IN pedido_id INT)
BEGIN
    SELECT 
        producto.nombre AS Producto, 
        producto.precio AS Precio, 
        comanda_producto.cantidad AS Unidades, 
        (producto.precio * comanda_producto.cantidad) AS Subtotal
    FROM 
        producto
    INNER JOIN 
        comanda_producto ON producto.id = comanda_producto.id_producto
    INNER JOIN 
        comanda ON comanda.id = comanda_producto.id_comanda
    INNER JOIN 
        pedido ON pedido.id = comanda.id_pedido
    WHERE 
        pedido.id = pedido_id;
END$$

DELIMITER ;


------Cursor

DELIMITER $$

CREATE PROCEDURE `CalcularPrecioFinalPedidoConCursor`(IN pedido_id INT, OUT precio_final FLOAT)
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE comanda_id INT;
    DECLARE producto_precio FLOAT;
    DECLARE cantidad INT;
    DECLARE total FLOAT DEFAULT 0;

    DECLARE cur CURSOR FOR
        SELECT c.id, p.precio, cp.cantidad
        FROM comanda c
        INNER JOIN comanda_producto cp ON c.id = cp.id_comanda
        INNER JOIN producto p ON cp.id_producto = p.id
        WHERE c.id_pedido = pedido_id;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    SET total = 0;
    
    START TRANSACTION;

    OPEN cur;

    read_loop: LOOP
        FETCH cur INTO comanda_id, producto_precio, cantidad;
        IF done THEN
            LEAVE read_loop;
        END IF;
        SET total = total + (producto_precio * cantidad);
    END LOOP;

    CLOSE cur;

    SET precio_final = total;
    
    COMMIT;
END$$

DELIMITER ;

----
DELIMITER $$

CREATE PROCEDURE CrearComanda(IN id_pedido INT)
BEGIN
    INSERT INTO comanda (id_pedido) VALUES (id_pedido);
END$$

DELIMITER ;

-----

DELIMITER $$

CREATE PROCEDURE CrearPedido(IN precio FLOAT, IN en_curso VARCHAR(5), IN fecha DATE, IN id_mesa INT)
BEGIN
    INSERT INTO pedido (precio, en_curso, fecha, id_mesa) VALUES (precio, en_curso, fecha, id_mesa);
END$$

DELIMITER ;

----

DELIMITER $$

CREATE PROCEDURE `FinalizarPedido`(IN pedido_id INT)
BEGIN
    UPDATE pedido
    SET en_curso = 'false'
    WHERE id = pedido_id;
END$$

DELIMITER ;

-------

DELIMITER $$

CREATE PROCEDURE `ObtenerMesasOcupadas`()
BEGIN
    SELECT m.id, m.nombre, p.id AS id_pedido
    FROM mesa m
    INNER JOIN pedido p ON m.id = p.id_mesa
    WHERE p.en_curso = 'true';
END$$

DELIMITER ;

-------

DELIMITER $$

CREATE PROCEDURE ObtenerMesasDisponibles()
BEGIN
    SELECT id, nombre
    FROM mesa
    WHERE id NOT IN (SELECT id_mesa FROM pedido WHERE en_curso = 'true');
END$$

DELIMITER ;

-----

DELIMITER $$

CREATE PROCEDURE ObtenerProductosPorCategoria(IN categoria_id INT)
BEGIN
    SELECT id, nombre, precio
    FROM producto
    WHERE id_categoria = categoria_id;
END$$

DELIMITER ;




