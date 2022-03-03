
<?php
$mysqli = include_once "conexion.php";
$id = $_POST["id"];
$nombre = $_POST["convenio"];
$descuento = $_POST["tiempo"];

$sentencia = $mysqli->prepare("UPDATE convenios SET
nombre_convenio = ?,
tiempo= ?
WHERE id_convenio = ?");
$sentencia->bind_param("sii", $nombre,$descuento,$id);
$sentencia->execute();
header("Location: listar.php");
