
<?php
include '../settings.php'; 
include_once "encabezado.php";

$id = $_POST["id"];
$nombre = $_POST["convenio"];
$descuento = $_POST["tiempo"];

$sentencia = $conn->prepare("UPDATE convenios SET
nombre_convenio = ?,
tiempo= ?
WHERE id_convenio = ?");
$sentencia->bind_param("sii", $nombre,$descuento,$id);
$sentencia->execute();
echo '<script>toastr.success("Registro Actualizado ")</script>';
header("refresh: 1; url=listar.php");

