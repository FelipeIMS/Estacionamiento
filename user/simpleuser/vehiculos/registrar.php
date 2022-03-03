
<?php
$mysqli = include_once "conexion.php";
$patente = $_POST["patente"];
$tipo = $_POST["tipo"];
$marca = $_POST["marca"];
$cliente = $_POST["cliente"];


$sentencia = $mysqli->prepare("INSERT INTO vehiculo
(patente,tipo_vehiculo,marca_vehiculo,cliente)
VALUES
(?,?,?,?)");
$sentencia->bind_param("siii",$patente,$tipo,$marca,$cliente);
$sentencia->execute();
header("Location: listar.php");
