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
     
                 if($row['termino']==""){
                     $sql2 = " UPDATE ficha set  user_ficha_out = '{$_SESSION['id']}' where id_ficha='".$_GET["id"]."'";
                     $result2 = mysqli_query($conn, $sql2);
                     
                     $sql4="UPDATE cliente c
                     JOIN vehiculo v  ON c.id_cliente = v.cliente
                     SET c.estado= 'Activo'
                     WHERE v.patente='".$row['patente']."'";
                     mysqli_query($conn,$sql4);
                     
                     $query3 = "UPDATE ficha SET termino = now() where id_ficha='".$_GET["id"]."'";
                     $result3 = mysqli_query($conn, $query3);
                     $query7 = "SELECT termino from ficha where id_ficha ='".$_GET["id"]."' ;";
                     $result7 = mysqli_query($conn, $query7);
                     $termino = mysqli_fetch_array($result7);
     
     
                     $sql5 = "SELECT timestampdiff(MINUTE,inicio,termino) from ficha where id_ficha='".$_GET["id"]."';";
                     $result5 = mysqli_query($conn, $sql5);
                     $diferencia = mysqli_fetch_array($result5);
                     $query6 = "UPDATE ficha SET diferencia = $diferencia[0] where id_ficha='".$_GET["id"]."'";
                     $result6 = mysqli_query($conn, $query6); 
     
     
                     if($row['convenion'] == 'Pacientes'){
                         $total = ($diferencia[0]-60)*20;
                         if($total < 0){
                             $total = 0;
                         }
                     }else if($row['convenion'] == 'Gratis'){
                         $total = $diferencia[0]*0;
                     }else{
                         $total = $diferencia[0]*20;
     
                     }
                     
                     $query4 = "UPDATE ficha SET total = '$total' where id_ficha='".$_GET["id"]."'";
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
                 }else{
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
             }
     
     ?>
</body>

</html>