
<?php
include_once "encabezado.php";

include '../settings.php'; 
$id = $_POST["id"];
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$area = $_POST["area"];
$convenio = $_POST["convenio"];
$cargo = $_POST["cargo"];


$sentencia = $conn->prepare("UPDATE cliente SET
nombre_cliente = ?,
apellido_cliente = ?,
area=?,
convenio=?,
cargo= ?
WHERE id_cliente = ?");
$sentencia->bind_param("ssiiii", $nombre, $apellidos, $area, $convenio, $cargo, $id);
$sentencia->execute();
echo '<script>toastr.success("Registro Actualizado ")</script>';
header("refresh: 1; url=listar.php");
