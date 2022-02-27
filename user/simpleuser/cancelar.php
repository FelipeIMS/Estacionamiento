<?php  include('settings.php');


if(isset($_POST["employee_id"])){

    $query1 = "SELECT cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia, total from ficha
    inner join vehiculo on vehiculo.patente = ficha.patente
    inner join cliente on cliente.id_cliente = vehiculo.cliente
    inner join area on area.id_area = cliente.area
    WHERE id_ficha ='".$_POST["employee_id"]."'";
        
    $result1 = mysqli_query($conn, $query1);
    
    
    $sql2 = " UPDATE ficha set  user_ficha_out = null()";
    $result2 = mysqli_query($conn, $sql2);
    
    $query3 = "UPDATE ficha SET termino = null() where id_ficha='".$_POST["employee_id"]."'";
    $result3 = mysqli_query($conn, $query3);
}

?>