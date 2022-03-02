<?php include('header.php') ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php
    include 'settings.php';

    $id = $_GET["id"];

    $sentencia = $conn->prepare("SELECT id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado from ficha
    inner join vehiculo on vehiculo.patente = ficha.patente
    inner join cliente on cliente.id_cliente = vehiculo.cliente
    inner join area on area.id_area = cliente.area
    inner join convenios on cliente.convenio = convenios.id_convenio
    WHERE id_ficha = ?");
    $sentencia->bind_param("i", $id);
    $sentencia->execute();
    $resultado = $sentencia->get_result();

    # Obtenemos solo una fila, que será el CLIENTE a editar
    $cliente = $resultado->fetch_assoc();
    if (!$cliente) {
        exit("No hay resultados para ese ID");
    }

    if($cliente['termino'] == ''){

        #agregamos el update de termino
        $horasalida= $conn->prepare("UPDATE ficha SET termino=now() WHERE id_ficha= ?");
        $horasalida ->bind_param("i",$id);
        $horasalida->execute();

        #Registramos el usuario que finalizara la salida
        $user_out = $conn->prepare("UPDATE ficha  SET user_ficha_out= '{$_SESSION['id']}' WHERE id_ficha= ?");
        $user_out->bind_param("i", $id);
        $user_out->execute();


        $termino_cliente = $conn ->prepare ("SELECT termino from ficha where WHERE id_ficha= ?");
        $termino_cliente -> bind_param("i", $id);
        $termino_cliente -> execute();
        $resultado3 -> get_result($termino_cliente);
        echo $resultado3[0];


        $sql5 = "SELECT timestampdiff(MINUTE,inicio,termino) from ficha where id_ficha='".$_POST["employee_id"]."';";
        $result5 = mysqli_query($conn, $sql5);

        $diferencia = mysqli_fetch_array($result5);

        $query6 = "UPDATE ficha SET diferencia = $diferencia[0] where id_ficha='".$_POST["employee_id"]."'";
        $result6 = mysqli_query($conn, $query6); 
    
    
        #Reactivamos cliente, para habilitar patentes asociadas
        $activar_cliente = $conn->prepare("UPDATE cliente c
           JOIN vehiculo v ON c.id_cliente = v.cliente
           SET c.estado='Activo'
           WHERE v.patente='" . $cliente['patente'] . "'");
        $activar_cliente->execute();

        $sentencia = $conn->prepare("SELECT id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado from ficha
        inner join vehiculo on vehiculo.patente = ficha.patente
        inner join cliente on cliente.id_cliente = vehiculo.cliente
        inner join area on area.id_area = cliente.area
        inner join convenios on cliente.convenio = convenios.id_convenio
        WHERE id_ficha = ?");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();

        # Obtenemos solo una fila, que será el CLIENTE a editar
        $cliente = $resultado->fetch_assoc();
        if (!$cliente) {
            exit("No hay resultados para ese ID");
        }
    }else{
        
    
    
        $sentencia2 = $conn->prepare("SELECT id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado from ficha
        inner join vehiculo on vehiculo.patente = ficha.patente
        inner join cliente on cliente.id_cliente = vehiculo.cliente
        inner join area on area.id_area = cliente.area
        inner join convenios on cliente.convenio = convenios.id_convenio
        WHERE id_ficha = ?");
        $sentencia2->bind_param("i", $id);
        $sentencia2->execute();
        $resultado2 = $sentencia2->get_result();
    
        # Obtenemos solo una fila, que será el CLIENTE a editar
        $cliente2 = $resultado2->fetch_assoc();
        if (!$cliente2) {
            exit("No hay resultados para ese ID");
        }

        echo $cliente2['termino'];

    }

    ?>

    <div class="row">
        <div class="col-12">
            <h1>PAGO Cliente</h1>
            <form action="pagoxd.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $cliente["id_ficha"] ?>">
                <div class="form-group">
                    <label for="nombre">ENTRADA</label>
                    <input value="<?php echo $cliente["inicio"] ?>" placeholder="entrada" class="form-control" type="text" name="entrada" id="entrada">
                </div>
                <div class="form-group">
                    <label for="nombre">SALIDA</label>
                    <input value="<?php  echo $cliente["termino"] ?>" placeholder="termino" class="form-control" type="text" name="termino" id="termino">
                </div>
                <div class="form-group">
                    <label for="nombre">TIEMPO</label>
                    <input value="<?php echo $cliente["diferencia"] ?>" placeholder="entrada" class="form-control" type="text" name="diferencia" id="diferencia">
                </div>
                <label for="convenio">Hospitalizado</label>
                <input id="checkbox" type="checkbox">
        </div>
        <div class="form-group">
            <label for="nombre">Total</label>
            <input id="total" name="total" value="<?php echo $cliente["total"] ?>" placeholder="" class="form-control" type="text">
        </div>

        <div class="form-group">
            <button class="btn btn-success">Guardar</button>
            <a class="btn btn-warning" href="index.php">Volver</a>
        </div>
        </form>
    </div>
    </div>
</body>
<?php include('footer.php'); ?>


<script>
    function on() {
        console.log(" on");
    }

    function off() {
        console.log("off");
    }

    var checkbox = document.getElementById('checkbox');
    checkbox.addEventListener("change", comprueba, false);

    function comprueba() {
        if (checkbox.checked) {
            on();
            var cantidad = 60;
            var diferencia = $("#diferencia").val();
            var total = $("#total").val();
            var dift = diferencia - cantidad;
            total = dift * 20;
            $("#total").val(total);
            alert(total);
        } else {
            off();
            var total = $("#total").val();
            total = 0;
            $("#total").val(total);
            alert(total);
        }
    }
</script>

</html>