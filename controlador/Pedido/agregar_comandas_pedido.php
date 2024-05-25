<?php

// Incluir los archivos necesarios y crear las instancias de los modelos

require "../../modelo/conexion.php";
require "../../modelo/mesas.php";
require "../../modelo/pedido.php";
require "../../modelo/comanda.php";

$mesa = new Mesas($conexion);
$pedido = new Pedido($conexion);
$comanda = new Comanda($conexion);

// Obtener las mesas ocupadas
$mesas_ocupadas = $mesa->obtenerMesasOcupadas();

// Manejar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se ha seleccionado una mesa
    if (isset($_POST['id_mesa'])) {
        $id_mesa = $_POST['id_mesa'];
        
        // Obtener el id del pedido asociado a la mesa seleccionada
        $id_pedido = $pedido->obtenerPedidoPorMesa($id_mesa);
        
        if ($id_pedido) {
            // Aquí deberías manejar la creación de nuevas comandas para el pedido
            // utilizando los datos recibidos del formulario.
            // Ejemplo:
            $productos = $_POST['productos'];
             $cantidades = $_POST['cantidades'];
            for ($i = 0; $i < count($productos); $i++) {
                $comanda->crearComanda($id_pedido, $productos[$i], $cantidades[$i]);
             }
            // Donde $productos y $cantidades son arrays con los datos de los productos y sus cantidades.
            
            // Redireccionar o mostrar un mensaje de éxito
            header("Location: ../../vista/Comandas/listar/php?id_pedido=$id_pedido");
            exit();
        } else {
            // Manejar el caso en el que no se pueda obtener el pedido asociado a la mesa
            $error = "No se pudo obtener el pedido asociado a la mesa seleccionada.";
        }
    } else {
        // Manejar el caso en el que no se haya seleccionado ninguna mesa
        $error = "Debe seleccionar una mesa.";
    }
}

