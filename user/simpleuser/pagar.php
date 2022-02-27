<?php include('settings.php');
$query3 = "UPDATE ficha SET diferencia = '' where id_ficha='".$_POST["employee_id"]."'";
$result2 = mysqli_query($conn, $query3); 

       $total = $df2*20;
           $query4 = "UPDATE ficha SET total = '$total' where id_ficha='".$_POST["employee_id"]."'";
           $result2 = mysqli_query($conn, $query4); 

?>
