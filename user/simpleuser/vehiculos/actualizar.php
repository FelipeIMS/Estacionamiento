
<?php
$mysqli = include_once "conexion.php";
$id = $_POST["id"];
$tipo = $_POST["tipo"];
$marca = $_POST["marca"];
$sentencia = $mysqli->prepare("UPDATE vehiculo SET
tipo_vehiculo = ?,
marca_vehiculo = ?
WHERE id_vehiculo = ?");
$sentencia->bind_param("iii", $tipo,$marca,$id);
$sentencia->execute();
header("Location: listar.php");
