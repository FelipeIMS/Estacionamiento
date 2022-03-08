<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php')?>
    <title>Hecho</title>
</head>
<body>
    
</body>
</html>

<?php  include('settings.php');



$id = $_GET["id"];


#llamamos a toda la ficha para poder activar al cliente al momento de pagar.
$sentencia3 = $conn->prepare("SELECT id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado, convenios.tiempo, ficha.convenio_sn, ficha.convenio_t, ficha.convenio_v from ficha
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


#cambiar valores a null

$restaurar = $conn->prepare("UPDATE ficha  SET termino= null, user_ficha_out = null, total= null, diferencia = null, convenio_v= null WHERE id_ficha= ?");
$restaurar->bind_param("i", $id);
$restaurar->execute();

header("Location: index.php");




?>