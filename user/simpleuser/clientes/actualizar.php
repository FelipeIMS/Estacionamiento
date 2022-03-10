
<?php
include_once "encabezado.php";

$mysqli = include_once "conexion.php";
$id = $_POST["id"];
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$area = $_POST["area"];
$convenio = $_POST["convenio"];
$cargo = $_POST["cargo"];

echo $id;
echo $nombre;
echo $apellidos;
echo $area;
echo $convenio;
echo $cargo;


$sentencia = mysqli_query($mysqli, "UPDATE cliente SET
nombre_cliente = '".$nombre."',
apellido_cliente = '".$apellidos."',
area= '".$area."',
convenio= '".$convenio."',
cargo= '".$cargo."'
WHERE id_cliente = '".$id."'");
echo '<script>toastr.success("Registro Actualizado ")</script>';
header("refresh: 1; url=listar.php");
