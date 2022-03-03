
<?php
$mysqli = include_once "conexion.php";
$id = $_POST["id"];
$nombre = $_POST["nombre_area"];

$sentencia = $mysqli->prepare("UPDATE area SET
nombre_area = ?
WHERE id_area = ?");
$sentencia->bind_param("si", $nombre,$id);
$sentencia->execute();
header("Location: listar.php");
