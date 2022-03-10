
<?php
include '../settings.php'; 
include_once "encabezado.php";

$id = $_POST["id"];
$marca = $_POST["marca"];

$sentencia = $conn->prepare("UPDATE marca_vehiculo SET
nombre_marca = ?
WHERE id_mv = ?");
$sentencia->bind_param("si", $marca,$id);
$sentencia->execute();
echo '<script>toastr.success("Registro Actualizado")</script>';
header("refresh: 1; url=listar.php");

