
<?php
    include_once "encabezado.php";

if (!isset($_GET["id"])) {
    exit("No hay id");
}
$mysqli = include_once "conexion.php";
$id = $_GET["id"];
$estado='Activo';
$sentencia = $mysqli->prepare("UPDATE vehiculo SET
estado_v = ?
WHERE id_vehiculo = ?");
$sentencia->bind_param("si",$estado ,$id);
$sentencia->execute();
header("Location: listar.php");
