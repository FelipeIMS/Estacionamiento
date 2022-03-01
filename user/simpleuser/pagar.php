<?php include('settings.php');

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pagado</title>
    <?php include('header.php');?>
</head>

<body>
    <?php

$total = "<script>document.write(localStorage.getItem('total'));</script>";




     if(isset($_GET["id"]))
     {
         $output = '';
         $query1 = "SELECT id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion,  ficha.estado from ficha
         inner join vehiculo on vehiculo.patente = ficha.patente
         inner join cliente on cliente.id_cliente = vehiculo.cliente
         inner join area on area.id_area = cliente.area
         inner join convenios on cliente.convenio = convenios.id_convenio
         WHERE id_ficha ='".$_GET["id"]."'";

         
         $result1 = mysqli_query($conn, $query1);
         $output .= '  
             <div class="table-responsive">  
                 <table class="table table-bordered">';
             while($row = mysqli_fetch_array($result1))
             {


                     
                     $query4 = "UPDATE ficha SET total = '' where id_ficha='".$_GET["id"]."'";
                     $result2 = mysqli_query($conn, $query4);
                     $query8 = "UPDATE ficha SET estado = 'Pagado' where id_ficha='".$_GET["id"]."'";
                     $result8 = mysqli_query($conn, $query8);
     
                     echo "<script>  Swal.fire({
                         position: 'center',
                         icon: 'success',
                         title: 'Pago realizado',
                         text:'Pago realizado correctamente',
                         showConfirmButton: false,
                         timer: 3000
                     });</script>";
                     echo '<script type="text/JavaScript"> setTimeout(function(){
                         window.location="index.php";
                     }, 2000); </script>';
                    
                    echo "<script>  Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: 'Error al pagar',
                        text:'Pago ya realizado, verifique salida',
                        showConfirmButton: false,
                        timer: 3000
                    });</script>";
                    echo '<script type="text/JavaScript"> setTimeout(function(){
                        window.location="index.php";
                    }, 2000); </script>';
             }
             
            }
     ?>
<input type="text" name="f1t1" id="f1t1">
</body>


<script>
    $("#f1t1").val('30');
</script>



</html>