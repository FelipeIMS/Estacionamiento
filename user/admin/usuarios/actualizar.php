
<?php
include '../settings.php';
include_once "encabezado.php";

$id = $_POST["id"];
$cargo = $_POST["cargo"];

$sentencia = $mysqli->prepare("UPDATE cargo SET
cargo = ?
WHERE id_cargo = ?");
$sentencia->bind_param("si", $cargo,$id);
$sentencia->execute();
echo '<script>toastr.success("Registro Actualizado")</script>';
header("refresh: 1; url=listar.php");

