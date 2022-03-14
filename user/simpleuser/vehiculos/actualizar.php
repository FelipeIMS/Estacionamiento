
<?php
$mysqli = include_once "conexion.php";
$id = $_POST["id"];
$tipo = $_POST["tipo"];
$marca = $_POST["marca"];
$obs = $_POST["obs"];
$sentencia = $mysqli->prepare("UPDATE vehiculo SET
tipo_vehiculo = ?,
marca_vehiculo = ?,
observacion = ?
WHERE id_vehiculo = ?");
$sentencia->bind_param("iisi", $tipo,$marca,$obs,$id);
$sentencia->execute();
header("Location: listar.php");
