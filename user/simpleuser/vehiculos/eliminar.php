
<?php
if (!isset($_GET["id"])) {
    exit("No hay id");
}
$mysqli = include_once "conexion.php";
$id = $_GET["id"];
$sentencia = $mysqli->prepare("DELETE FROM vehiculo WHERE id_vehiculo = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
header("Location: listar.php");
