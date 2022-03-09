
<?php
include_once "encabezado.php";
include 'conexion.php';
$id = $_GET["id"];
$estado = 'Activo';
$query = mysqli_query($mysqli, "SELECT * FROM marca_vehiculo
WHERE id_mv='$id'");

if (mysqli_num_rows($query) < 0) {
    echo '<script>toastr.error("Marca no existe")</script>';
    header("refresh: 1; url=listar.php");
} else {
    $sentencia = $mysqli->prepare("UPDATE marca_vehiculo SET
estado_m = ?
WHERE id_mv = ?");
    $sentencia->bind_param("si", $estado, $id);
    $sentencia->execute();
    echo '<script>toastr.success("Marca Activa")</script>';
    header("refresh: 1; url=listar.php");
}
