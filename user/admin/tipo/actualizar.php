
<?php
$mysqli = include_once "conexion.php";
include_once "encabezado.php";

$id = $_POST["id"];
$tipo = $_POST["tipo"];

$sentencia = $mysqli->prepare("UPDATE tipo_vehiculo SET
nombre_tpv = ?
WHERE id_tpv = ?");
$sentencia->bind_param("si", $tipo,$id);
$sentencia->execute();
echo '<script>toastr.success("Registro Actualizado")</script>';
header("refresh: 1; url=listar.php");

