
<?php
include_once "encabezado.php";
include 'settings.php';
$id = $_POST["id"];
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$area = $_POST["area"];
$convenio = $_POST["convenio"];

$sentencia = $conn->prepare("UPDATE cliente SET
nombre_cliente = ?,
apellido_cliente = ?,
area=?,
convenio=?
WHERE id_cliente = ?");
$sentencia->bind_param("ssiii", $nombre, $apellidos, $area,$convenio,$id);
$sentencia->execute();
echo '<script>toastr.success("Registro Actualizado ")</script>';
header("refresh: 1; url=listar_cliente.php");
