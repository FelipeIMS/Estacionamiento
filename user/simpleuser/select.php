<?php
include('settings.php');

if(isset($_POST["employee_id"]))
{

 $query2 = "UPDATE ficha SET termino = now() where id_ficha='".$_POST["employee_id"]."'";
 $result = mysqli_query($conn, $query2);
 

 $output = '';
 $query = "SELECT cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, timestampdiff(MINUTE, inicio, termino) as df2, diferencia, total from ficha
 inner join vehiculo on vehiculo.patente = ficha.patente
 inner join cliente on cliente.id_cliente = vehiculo.cliente
 inner join area on area.id_area = cliente.area
 WHERE id_ficha ='".$_POST["employee_id"]."'";
 
 $result = mysqli_query($conn, $query);
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';
    while($row = mysqli_fetch_array($result))
    {
       $df2=  $row["df2"];

       $query3 = "UPDATE ficha SET diferencia = '$df2' where id_ficha='".$_POST["employee_id"]."'";
       $result2 = mysqli_query($conn, $query3); 
       if($df2>0){
           $total = $df2*20;
           $query4 = "UPDATE ficha SET total = '$total' where id_ficha='".$_POST["employee_id"]."'";
           $result2 = mysqli_query($conn, $query4); 

           $output .= '
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
                  <td width="30%"><label>Tiempo estacionado</label></td>  
                  <td width="70%">'.$row["diferencia"].'</td>  
              </tr>
              <tr>  
                  <td width="30%"><label>Total</label></td>  
                  <td width="70%">'.$total.'</td>  
              </tr>
              ';
          }
          $output .= '</table></div>';
          echo $output;
       }

}
?>