
<?php
$mysqli = include_once "conexion.php";
$id = $_POST["id"];
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$area = $_POST["area"];
$convenio = $_POST["convenio"];

$sentencia = $mysqli->prepare("UPDATE cliente SET
nombre_cliente = ?,
apellido_cliente = ?,
area=?,
convenio=?
WHERE id_cliente = ?");
$sentencia->bind_param("ssiii", $nombre, $apellidos, $area,$convenio,$id);
$sentencia->execute();
header("Location: listar.php");
