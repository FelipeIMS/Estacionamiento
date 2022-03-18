
<?php
$mysqli = include_once "conexion.php";
$id = $_POST["id"];
$tipo = $_POST["tipo"];
$marca = $_POST["marca"];
$obs = $_POST["obs"];
$patente = $_POST["patente"];
$sentencia = $mysqli->prepare("UPDATE vehiculo SET
tipo_vehiculo = ?,
marca_vehiculo = ?,
observacion = ?,
patente = ?
WHERE id_vehiculo = ?");
$sentencia->bind_param("iissi", $tipo,$marca,$obs, $patente,$id);
$sentencia->execute();
header("Location: listar.php");
