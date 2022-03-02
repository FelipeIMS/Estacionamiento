<?php
include 'settings.php';

$id = $_POST["id"];
$pago = $_POST["total"];


#llamamos a toda la ficha para poder activar al cliente al momento de pagar.
$sentencia3 = $conn->prepare("SELECT id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado from ficha
inner join vehiculo on vehiculo.patente = ficha.patente
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area
inner join convenios on cliente.convenio = convenios.id_convenio
WHERE id_ficha = ?");
$sentencia3->bind_param("i", $id);
$sentencia3->execute();
$resultado3 = $sentencia3->get_result();

# Obtenemos solo una fila, que será el CLIENTE a editar
$cliente3 = $resultado3->fetch_assoc();
if (!$cliente3) {
    exit("No hay resultados para ese ID");
}
#Reactivamos cliente, para habilitar patentes asociadas
$activar_cliente = $conn->prepare("UPDATE cliente c
JOIN vehiculo v ON c.id_cliente = v.cliente
SET c.estado='Activo'
WHERE v.patente='" . $cliente3['patente'] . "'");
$activar_cliente->execute();
$sentencia = $conn->prepare("UPDATE ficha SET
total = ?
WHERE id_ficha = ?");
$sentencia->bind_param("ii", $pago, $id);
$sentencia->execute();

#Registramos el usuario que finalizara la salida
$user_out = $conn->prepare("UPDATE ficha  SET user_ficha_out= '{$_SESSION['id']}' WHERE id_ficha= ?");
$user_out->bind_param("i", $id);
$user_out->execute();

#cambiar estado de pago

$estado_pago = $conn->prepare("UPDATE ficha  SET estado= 'Pagado' WHERE id_ficha= ?");
$estado_pago->bind_param("i", $id);
$estado_pago->execute();
header("Location: index.php");
