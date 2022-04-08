<?php

include('settings.php');

if(!isset($_GET['palabraClave'])){ 
    $json = [];
}else{
    $search = $_GET['palabraClave'];
    $sql = "SELECT id_cliente, CONCAT(nombre_cliente, ' ', apellido_cliente) as nombre FROM cliente 
            WHERE nombre_cliente LIKE '%".$search."%' order by nombre_cliente
            LIMIT 10"; 
    $result = $conn->query($sql);
    $json = [];
    while($row = $result->fetch_assoc()){
        $json[] = ['id'=>$row['id_cliente'], 'text'=>$row['nombre']];
    }
}

echo json_encode($json);

?>