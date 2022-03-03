
<?php
$mysqli = include_once "conexion.php";
$nombre = $_POST["nombreconvenio"];
$tiempo = $_POST["descuento"];


$sentencia = $mysqli->prepare("INSERT INTO convenios
(nombre_convenio,tiempo)
VALUES
(?,?)");
$sentencia->bind_param("si",$nombre,$tiempo);
$sentencia->execute();
header("Location: listar.php");
