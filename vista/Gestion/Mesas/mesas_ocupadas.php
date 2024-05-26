<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas ocupadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/aec7d72014.js" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Mesas</h1>

    <form name="SelMesaForm" method="post">
        <div>
            <?php
                include "../../../modelo/conexion.php";
                ?>
                <?php
                include "../../../componentes/seleccionmesaocupada.php";
                ?>
        </div>
    </form>

    <!--las etiquetas extra php son para que podamos
    cambiar las etiquetas en base a si hay mesas disponibles o no -->
    <?php if (!empty($mesas)) { ?>
        <a href="../../../vista/Pedidos/anadir_comanda.php?id=<?= $mesas[0]['id'] ?>" class="btn btn-primary">Seleccionar<i class="fa-solid fa-pen-to-square"></i></a>
    <?php } else { ?>
        <a href="#" class="btn btn-primary disabled">No hay mesas ocupadas</a>
    <?php } ?>
    
    <a href="../../../vista/Pedidos/menu.php"><button class="btn btn-primary">Atrás</button></a>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>