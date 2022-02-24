<?php
	include 'settings.php';
	
	$search = $_GET['term'];

	$query = $conn->query("SELECT *  FROM vehiculo
	INNER JOIN cliente ON cliente.id_cliente = vehiculo.cliente
	 WHERE cliente.estado='Activo' AND
	CONCAT(cliente.nombre_cliente,' ',cliente.apellido_cliente) LIKE '%$search%' OR vehiculo.patente LIKE '%$search%'   ") or die(mysqli_connect_errno());
	
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