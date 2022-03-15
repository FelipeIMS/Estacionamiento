<?php
require_once ('../settings.php');

$search = $_GET['term'];
 
$query = $conn->query("SELECT vehiculo.patente,cliente.nombre_cliente FROM `vehiculo`
INNER JOIN cliente ON cliente.id_cliente = vehiculo.cliente
WHERE `patente` LIKE '%$search%' ORDER BY `patente` ASC") or die(mysqli_connect_errno());

$list = array();
$rows = $query->num_rows;

if($rows > 0){
    while($fetch = $query->fetch_assoc()){
        $data['value'] = $fetch['patente']; 
        array_push($list, $data);
    }
}

echo json_encode($list);
?>