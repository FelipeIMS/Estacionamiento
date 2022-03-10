<?php
include '../settings.php';
$sql = "SELECT * FROM cliente 
        WHERE CONCAT(cliente.nombre_cliente,' ',cliente.apellido_cliente) LIKE '%".$_GET['q']."%'
        LIMIT 10"; 
$result = $conn->query($sql);
$json = [];
while($row = $result->fetch_assoc()){
     $json[] = ['id'=>$row['id_cliente'], 'text'=>$row['apellido_cliente']];
}
echo json_encode($json);
?>