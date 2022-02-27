<?php
include('settings.php');

if(isset($_POST["employee_id"]))
{
    $output = '';
    $query1 = "SELECT cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia, total from ficha
    inner join vehiculo on vehiculo.patente = ficha.patente
    inner join cliente on cliente.id_cliente = vehiculo.cliente
    inner join area on area.id_area = cliente.area
    WHERE id_ficha ='".$_POST["employee_id"]."'";
    
    $result1 = mysqli_query($conn, $query1);
    $output .= '  
        <div class="table-responsive">  
            <table class="table table-bordered">';
        while($row = mysqli_fetch_array($result1))
        {

            if($row['termino']==""){
                $sql2 = " UPDATE ficha set  user_ficha_out = '{$_SESSION['id']}'";
                $result2 = mysqli_query($conn, $sql2);

                $query3 = "UPDATE ficha SET termino = now() where id_ficha='".$_POST["employee_id"]."'";
                $result3 = mysqli_query($conn, $query3);
                $query7 = "SELECT termino from ficha where id_ficha ='".$_POST["employee_id"]."' ;";
                $result7 = mysqli_query($conn, $query7);
                $termino = mysqli_fetch_array($result7);


                $sql4="UPDATE cliente c
                JOIN vehiculo v  ON c.id_cliente = v.cliente
                SET c.estado= 'Activo'
                WHERE v.patente='".$row['patente']."'";
                mysqli_query($conn,$sql4);

                $sql5 = "SELECT timestampdiff(MINUTE,inicio,termino) from ficha where id_ficha='".$_POST['employee_id']."';";
                $result5 = mysqli_query($conn, $sql5);
                $diferencia = mysqli_fetch_array($result5);
                $query6 = "UPDATE ficha SET diferencia = $diferencia[0] where id_ficha='".$_POST["employee_id"]."'";
                $result6 = mysqli_query($conn, $query6); 
                $total = $diferencia[0]*20;
                $query4 = "UPDATE ficha SET total = '$total' where id_ficha='".$_POST["employee_id"]."'";
                $result2 = mysqli_query($conn, $query4);
                $output .= '
                <div class="">
                    <label for="recipient-name" class="col-form-label">Nombre</label>
                    <input disabled type="text" class="form-control" id="recipient-name" value='.$row["nombre_cliente"].'>
                    <label for="message-text" class="col-form-label">Apellido</label>
                    <input disabled type="text" class="form-control" id="recipient-name" value='.$row["apellido_cliente"].'>
                    <label for="message-text" class="col-form-label">Patente</label>
                    <input disabled type="text" class="form-control" id="recipient-name" value='.$row["patente"].'>
                    <label for="message-text" class="col-form-label">Area</label>
                    <input disabled type="text" class="form-control" id="recipient-name" value='.$row["nombre_area"].'>
                    <label for="message-text" class="col-form-label">Llegada</label>
                    <input disabled type="text" class="form-control" id="recipient-name" value='.$row["inicio"].'>
                    <label for="message-text" class="col-form-label">Salida</label>
                    <input disabled type="text" class="form-control" id="recipient-name" value='.$termino[0].'>
                    <label for="message-text" class="col-form-label">Tiempo estacionado</label>
                    <input disabled type="text" class="form-control" id="recipient-name" value='.$diferencia[0].'>
                    <label for="message-text" class="col-form-label">Total</label>
                    <input disabled type="text" class="form-control" id="recipient-name" value='.$total.'>
                </div>
                ';
                echo $output;
    

            }else if(isset($_POST['aceptar'])) {


            }else{
                $output .= '
          <div class="">
            <label for="recipient-name" class="col-form-label">Nombre</label>
            <input disabled type="text" class="form-control" id="recipient-name" value='.$row["nombre_cliente"].'>
            <label for="message-text" class="col-form-label">Apellido</label>
            <input disabled type="text" class="form-control" id="recipient-name" value='.$row["apellido_cliente"].'>
            <label for="message-text" class="col-form-label">Patente</label>
            <input disabled type="text" class="form-control" id="recipient-name" value='.$row["patente"].'>
            <label for="message-text" class="col-form-label">Area</label>
            <input disabled type="text" class="form-control" id="recipient-name" value='.$row["nombre_area"].'>
            <label for="message-text" class="col-form-label">Llegada</label>
            <input disabled type="text" class="form-control" id="recipient-name" value='.$row["inicio"].'>
            <label for="message-text" class="col-form-label">Salida</label>
            <input disabled type="text" class="form-control" id="recipient-name" value='.$row["termino"].'>
            <label for="message-text" class="col-form-label">Tiempo estacionado</label>
            <input disabled type="text" class="form-control" id="recipient-name" value='.$row["diferencia"].'>
            <label for="message-text" class="col-form-label">Total</label>
            <input disabled type="text" class="form-control" id="recipient-name" value='.$row["total"].'>
          </div>
                ';
                echo $output;

            }
        }
        }
           

?>