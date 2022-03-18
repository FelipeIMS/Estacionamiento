<?php include('./header.php') ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pagar</title>
</head>

<body>
    <?php
    include 'settings.php';

    $id = $_GET["id"];

    $sentencia = $conn->prepare("SELECT id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, convenios.tiempo,ficha.estado, ficha.convenio_sn, ficha.convenio_t, ficha.convenio_v from ficha
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

        #calculo de diferencia entre horas e inserta la diferencia en BD

        $sql5 = "SELECT timestampdiff(MINUTE,inicio,termino) as diferencia from ficha where id_ficha='".$_GET["id"]."';";
        $result5 = mysqli_query($conn, $sql5);
        $diferencia = mysqli_fetch_array($result5);
        $query6 = "UPDATE ficha SET diferencia = $diferencia[0] where id_ficha='".$_GET["id"]."'";
        $result6 = mysqli_query($conn, $query6); 

        $traerTiempoDesc = "SELECT id_ficha,convenios.tiempo as tiempo_c from ficha
        inner join vehiculo on vehiculo.patente = ficha.patente
        inner join cliente on cliente.id_cliente = vehiculo.cliente
        inner join area on area.id_area = cliente.area
        inner join convenios on cliente.convenio = convenios.id_convenio
        WHERE id_ficha = '".$_GET["id"]."'";
        $resultadoTD = mysqli_query($conn, $traerTiempoDesc);
        $TD = mysqli_fetch_array($resultadoTD);

        $valorXminuto = mysqli_query($conn, "SELECT precio from precio where estado_precio = 'Activo';");

        $VXP = mysqli_fetch_array($valorXminuto);
        
        

        if($cliente['convenion'] == 'Sin convenio'){

            $total = $diferencia[0]*$VXP[0];
            $query6 = "UPDATE ficha SET total = $total where id_ficha='".$_GET["id"]."'";
            $result6 = mysqli_query($conn, $query6); 
        }else if($cliente['convenion'] == 'Gratis'){
            $total = $TD[1]*$VXP[0];
            $query6 = "UPDATE ficha SET total = $total where id_ficha='".$_GET["id"]."'";
            $result6 = mysqli_query($conn, $query6); 

        }else{
            $cambio = $TD[1]/100;
            $total_sindesc=$diferencia[0]*$VXP[0];
            $desc = $total_sindesc*$cambio;
            $total_condesc = $total_sindesc - $desc;
            $query7 = "UPDATE ficha SET total = $total_condesc, convenio_v = $desc where id_ficha='".$_GET["id"]."'";
            $result7 = mysqli_query($conn, $query7); 
        }

        #Se carga nuevamente

        $sentencia = $conn->prepare("SELECT id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado, ficha.convenio_sn, ficha.convenio_t, ficha.convenio_v from ficha
        inner join vehiculo on vehiculo.patente = ficha.patente
        inner join cliente on cliente.id_cliente = vehiculo.cliente
        inner join area on area.id_area = cliente.area
        inner join convenios on cliente.convenio = convenios.id_convenio
        WHERE id_ficha = ?");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $cliente = $resultado->fetch_assoc();
        if (!$cliente) {
            exit("No hay resultados para ese ID");
        }

    }else{
        $user_out = $conn->prepare("UPDATE ficha  SET user_ficha_out= '{$_SESSION['id']}' WHERE id_ficha= ?");
        $user_out->bind_param("i", $id);
        $user_out->execute();

        #calculo de diferencia entre horas e inserta la diferencia en BD

        $sql5 = "SELECT timestampdiff(MINUTE,inicio,termino) as diferencia from ficha where id_ficha='".$_GET["id"]."';";
        $result5 = mysqli_query($conn, $sql5);
        $diferencia = mysqli_fetch_array($result5);
        $query6 = "UPDATE ficha SET diferencia = $diferencia[0] where id_ficha='".$_GET["id"]."'";
        $result6 = mysqli_query($conn, $query6); 

        $traerTiempoDesc = "SELECT id_ficha,convenios.tiempo as tiempo_c from ficha
        inner join vehiculo on vehiculo.patente = ficha.patente
        inner join cliente on cliente.id_cliente = vehiculo.cliente
        inner join area on area.id_area = cliente.area
        inner join convenios on cliente.convenio = convenios.id_convenio
        WHERE id_ficha = '".$_GET["id"]."'";
        $resultadoTD = mysqli_query($conn, $traerTiempoDesc);
        $TD = mysqli_fetch_array($resultadoTD);

        $valorXminuto = mysqli_query($conn, "SELECT precio from precio where estado_precio = 'Activo';");

        $VXP = mysqli_fetch_array($valorXminuto);
        
        

        if($cliente['convenion'] == 'Sin convenio'){

            $total = $diferencia[0]*$VXP[0];
            $query6 = "UPDATE ficha SET total = $total where id_ficha='".$_GET["id"]."'";
            $result6 = mysqli_query($conn, $query6); 
        }else if($cliente['convenion'] == 'Gratis'){
            $total = $TD[1]*$VXP[0];
            $query6 = "UPDATE ficha SET total = $total where id_ficha='".$_GET["id"]."'";
            $result6 = mysqli_query($conn, $query6); 

        }else{
            $cambio = $TD[1]/100;
            $total_sindesc=$diferencia[0]*$VXP[0];
            $desc = $total_sindesc*$cambio;
            $total_condesc = $total_sindesc - $desc;
            $query7 = "UPDATE ficha SET total = $total_condesc, convenio_v = $desc where id_ficha='".$_GET["id"]."'";
            $result7 = mysqli_query($conn, $query7); 
        }

        #Se carga nuevamente

        $sentencia = $conn->prepare("SELECT id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado, ficha.convenio_sn, ficha.convenio_t, ficha.convenio_v from ficha
        inner join vehiculo on vehiculo.patente = ficha.patente
        inner join cliente on cliente.id_cliente = vehiculo.cliente
        inner join area on area.id_area = cliente.area
        inner join convenios on cliente.convenio = convenios.id_convenio
        WHERE id_ficha = ?");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $cliente = $resultado->fetch_assoc();
        if (!$cliente) {
            exit("No hay resultados para ese ID");
        }
        
    }

    ?>
    <div class="container mt-5  w-25">
        <div class="card text-center">
            <div class="card-header">
                PAGO Cliente
            </div>
            <div class="card-body ">
                <form action="pagoxd.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $cliente["id_ficha"] ?>">
                    <div class="form-group">
                        <label for="nombre">Nro Boleta: </label>
                        <input disabled class="text-center mt-3 w-50" value="<?php echo $cliente["id_ficha"] ?>"
                            placeholder="entrada" class="form-control" type="text" name="entrada" id="entrada">
                    </div>
                    <div class="form-group">
                        <label for="nombre">ENTRADA: </label>
                        <input disabled class="text-center mt-3 w-50" value="<?php echo $cliente["inicio"] ?>"
                            placeholder="entrada" class="form-control" type="text" name="entrada" id="entrada">
                    </div>
                    <div class="form-group">
                        <label for="nombre">SALIDA: </label>
                        <input disabled class="text-center mt-3 w-50" value="<?php  echo $cliente["termino"] ?>"
                            placeholder="termino" class="form-control" type="text" name="termino" id="termino">
                    </div>
                    <div class="form-group">
                        <label for="nombre">TIEMPO: </label>
                        <input disabled class="text-center mt-3 w-50" value="<?php echo $cliente['diferencia'] ?>"
                            placeholder="entrada" class="form-control" type="text" name="diferencia" id="diferencia" >
                        <input value="<?php echo $cliente['convenion'] ?>" placeholder="convenio si/no"
                            class="form-control" type="text" name="convenio_sn" id="convenio_sn" hidden>
                        <input value="<?php echo $cliente['convenio_t'] ?> 0" placeholder="convenio_t"
                            class="form-control" type="text" name="convenio_t" id="convenio_t" hidden>
                        <input value="<?php echo $cliente['convenio_v'] ?> 0" placeholder="convenio_v"
                            class="form-control" type="text" name="convenio_v" id="convenio_v" hidden>
                        <?php $valorXminuto = mysqli_query($conn, "SELECT precio from precio where estado_precio = 'Activo';");
                                $VXP = mysqli_fetch_array($valorXminuto);
                                echo '<input value="'.$VXP[0].'" placeholder="Precio"
                                class="form-control" type="text" name="precio" id="precio" hidden>';
                                ?>
                        <?php 
                                echo '<input value="0" placeholder="total"
                                class="form-control" type="text" name="total2" id="total2" hidden> ';
                                ?>

                    </div>
                    <div class="check-hosp">
                        <label class="mt-3" for="convenio" <?php if ($cliente['convenion'] != 'Sin convenio'){ ?>
                            style="display: none;" <?php   } ?>>Hospitalizado</label>
                        <input class="mt-3 text-center" id="checkbox" type="checkbox"
                            <?php if ($cliente['convenion'] != 'Sin convenio'){ ?> style="display: none;" <?php   } ?>>

                    </div>
                    <div class="check-gratis">

                        <label class="mt-3" for="gratis" <?php if ($cliente['convenion'] != 'Sin convenio'){ ?>
                            style="display: none;" <?php   } ?>>Gratis</label>
                        <input class="mt-3 text-center" id="gratis" type="checkbox" onclick="myFunction()"
                            <?php if ($cliente['convenion'] != 'Sin convenio'){ ?> style="display: none;" <?php   } ?>>
                    </div>
                    <div class="form-group mt-3 mb-3">
                        <label for="nombre">Total</label>
                        <input class="text-center" id="total" name="total" value="<?php echo $cliente["total"] ?>"
                            placeholder="" class="form-control" type="text" readonly>
                    </div>
                    <div class="form-group mt-3 mb-3">
                        <label for="nombre">Boleta SII</label>
                        <input type="number" class="" id="sii" name="sii" placeholder="Ingrese Nro boleta"
                            class="form-control" required>

                    </div>
                    <!-- <label class="mt-3" for="boleta_sii">Null</label>
                <input class="mt-3 text-center" id="boleta_sii" type="checkbox"> -->
            </div>
            <div class="card-footer text-muted">
                <div class="form-group text-center">
                    <button class="btn btn-success">Pagar</button>
                    <a class="btn btn-danger" href="cancelar.php?id=<?php echo $cliente["id_ficha"] ?>">Cancelar</a>
                </div>
            </div>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="form-floating mt-4">
            <textarea disabled readonly class="form-control" placeholder="Leave a comment here" id="floatingTextarea2"
                style="height: 100px">°Digita 0 para una boleta que tenga total 0.
°Digita 1 para ingresar manualmente la boleta SII mas tarde. </textarea>
            <label for="floatingTextarea2">Instrucciones</label>
        </div>
    </div>

</body>
<?php include('./footer.php'); ?>

<script>
$(document).ready(function() {
    var diferencia = $("#diferencia").val();
    var total = $("#total").val();

    if(diferencia >= 0 && diferencia <=5){
        total = 0;
    }else if (diferencia >= 6 && diferencia <= 10){
        total = 200;
    }
    $("#total").val(total);

    $(document).change(function() {
    var diferencia = $("#diferencia").val();
    var total = $("#total").val();

    if(diferencia >= 0 && diferencia <=5){
        total = 0;
    }else if (diferencia >= 6 && diferencia <= 10){
        total = 200;
    }
    $("#total").val(total);

    });

});
</script>

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
        var precio = $("#precio").val();
        var total2 = $("#total2").val();
        var dift = diferencia - cantidad;

        total2 = precio * diferencia;

        total = dift * precio;
        if (total < 0) {
            total = 0;
        }

        $("#convenio_sn").val("Hospitalizado");
        $("#convenio_t").val(cantidad);
        $("#convenio_v").val(precio * cantidad);
        $("#total").val(total);
        $("#total2").val(total2);
    } else {
        off();
        var total = $("#total").val();
        var precio = $("#precio").val();
        var diferencia = $("#diferencia").val();
        total = diferencia * precio;
        $("#convenio_sn").val("<?php echo $cliente['convenion'] ?>");
        $("#convenio_t").val(0);
        $("#convenio_v").val(0);
        $("#total2").val(0);
        $("#total").val(total);
    }
}
</script>
<script>
function myFunction() {
    var checkBox = document.getElementById("gratis");
    if (checkBox.checked == true) {
        console.log("on");
        var diferencia = $("#diferencia").val();
        var total = $("#total").val();
        var precio = $("#precio").val();
        var total2 = $("#total2").val();

        $("#convenio_sn").val("Gratis");
        $("#convenio_t").val(0);
        $("#convenio_v").val(0);
        $("#total").val(0);
        $("#total2").val(0);
    } else {
        console.log("off");
        var total = $("#total").val();
        var precio = $("#precio").val();
        var diferencia = $("#diferencia").val();
        total = diferencia * precio;
        $("#convenio_sn").val("<?php echo $cliente['convenion'] ?>");
        $("#convenio_t").val(0);
        $("#convenio_v").val(0);
        $("#total2").val(0);
        $("#total").val(total);
    }
}
</script>


<script type="text/javascript">
$(document).ready(function() {
    //Register click events to all checkboxes inside question element
    $(document).on('click', '.check-hosp input:checkbox', function() {

        if (this.checked) {
            $('.check-gratis').hide();
        } else {
            off();
            $('.check-gratis').show();
        }
    });

});
$(document).ready(function() {
    //Register click events to all checkboxes inside question element
    $(document).on('click', '.check-gratis input:checkbox', function() {


        if (this.checked) {
            $('.check-hosp').hide();
        } else {
            $('.check-hosp').show();

        }
    });

});
</script>

</html>