
<?php
$mysqli = include_once "conexion.php";
$rut = $_POST["rut"];
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$area = $_POST["area"];
$estado = $_POST["estado"];
$convenio = $_POST["convenio"];

$sentencia = $mysqli->prepare("INSERT INTO cliente
(rut, nombre_cliente,apellido_cliente,area,estado,convenio)
VALUES
(?, ?,?,?,?,?)");
$sentencia->bind_param("ssssss",$rut, $nombre, $apellidos,$area,$estado,$convenio);
$sentencia->execute();
header("Location: listar.php");
