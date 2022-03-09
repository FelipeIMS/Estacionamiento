
<?php
include_once "encabezado.php";
include '../settings.php'; 
$id = $_POST["id"];
$nombre = $_POST["nombre_area"];

$sentencia = $conn->prepare("UPDATE area SET
nombre_area = ?
WHERE id_area = ?");
$sentencia->bind_param("si", $nombre,$id);
$sentencia->execute();
echo '<script>toastr.success("Registro Actualizado ")</script>';
header("refresh: 1; url=listar.php");