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
                <tr>  
                <td width="30%"><label>Nombre</label></td>  
                <td width="70%">'.$row["nombre_cliente"].'</td>  
                </tr>
                <tr>  
                <td width="30%"><label>Apellido</label></td>  
                <td width="70%">'.$row["apellido_cliente"].'</td>  
                </tr>
                <tr>  
                <td width="30%"><label>Patente</label></td>  
                <td width="70%">'.$row["patente"].'</td>  
                </tr>
                <tr>  
                <td width="30%"><label>Area</label></td>  
                <td width="70%">'.$row["nombre_area"].'</td>  
                </tr>
                <tr>  
                <td width="30%"><label>Llegada</label></td>  
                <td width="70%">'.$row["inicio"].'</td>  
                </tr>
                <tr>  
                <td width="30%"><label>Salida</label></td>  
                <td width="70%">'.$termino[0].'</td>  
                </tr>
                <tr>  
                <td width="30%"><label>Tiempo estacionado (Minutos)</label></td>  
                <td width="70%">'.$diferencia[0].'</td>  
                </tr>
                <tr>  
                <td width="30%"><label>A pagar</label></td>  
                <td width="70%">'.$total.'</td>  
                </tr>
                <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                </div>
                ';
                echo $output;
    

            }else if(isset($_POST['aceptar'])) {


            }else{
                $output .= '
          <div class="">

            <tr>  
            <td width="30%"><label>Nombre</label></td>  
            <td width="70%">'.$row["nombre_cliente"].'</td>  
            </tr>
            <tr>  
            <td width="30%"><label>Apellido</label></td>  
            <td width="70%">'.$row["apellido_cliente"].'</td>  
            </tr>
            <tr>  
            <td width="30%"><label>Patente</label></td>  
            <td width="70%">'.$row["patente"].'</td>  
            </tr>
            <tr>  
            <td width="30%"><label>Area</label></td>  
            <td width="70%">'.$row["nombre_area"].'</td>  
            </tr>
            <tr>  
            <td width="30%"><label>Llegada</label></td>  
            <td width="70%">'.$row["inicio"].'</td>  
            </tr>
            <tr>  
            <td width="30%"><label>Salida</label></td>  
            <td width="70%">'.$row["termino"].'</td>  
            </tr>
            <tr>  
            <td width="30%"><label>Tiempo estacionado (Minutos)</label></td>  
            <td width="70%">'.$row["diferencia"].'</td>  
            </tr>
            <tr>  
            <td width="30%"><label>A pagar</label></td>  
            <td width="70%">'.$row["total"].'</td>  
            </tr>
            
          </div>
                ';
                echo $output;

            }
        }
        }
           

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>aa</title>
</head>
<body>
    
</body>
</html>