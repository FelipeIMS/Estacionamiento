
<?php
$mysqli = include_once "conexion.php";
$area = $_POST["area"];


$sentencia = $mysqli->prepare("INSERT INTO area
(nombre_area)
VALUES
(?)");
$sentencia->bind_param("s",$area);
$sentencia->execute();
header("Location: listar.php");
