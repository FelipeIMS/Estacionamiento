
<?php
include_once "settings.php";
$id = $_POST["id"];
$tipo = $_POST["tipo"];
$marca = $_POST["marca"];
$obs = $_POST["obs"];
$patente = $_POST["patente"];
$sentencia = $conn->prepare("UPDATE vehiculo SET
tipo_vehiculo = ?,
marca_vehiculo = ?,
observacion = ?,
patente = ?
WHERE id_vehiculo = ?");
$sentencia->bind_param("iissi", $tipo,$marca,$obs, $patente,$id);
$sentencia->execute();
echo '<script>toastr.success("Registro Actualizado ")</script>';
header("refresh: 1; url=listar.php");
