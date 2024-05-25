<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Comandas a Pedido</title>
    <!-- Agrega tus estilos y scripts necesarios aquí -->
</head>

<body>
    <h1>Agregar Comandas a Pedido</h1>
    
    <div class="col-md-4">
    <form name="CrearCatForm" method="post" action="../../controlador/Pedido/agregar_comandas_pedido.php">
            <!-- Aquí incluimos el componente de selección de mesas ocupadas -->
    <?php include "../../componentes/seleccionmesasocupadas.php"; ?>
    <button type="submit" class="btn btn-primary" name="btnmesaocupada" value="okmesa">Seleccionar esta mesa</button>
    </form>
    </div>


    <!-- Aquí puedes seguir con el resto de tu contenido HTML y PHP -->

</body>

</html>
