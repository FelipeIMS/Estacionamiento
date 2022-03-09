
<?php
include_once "encabezado.php";
include 'conexion.php';
$id = $_GET["id"];
$estado = 'Inactivo';
$query = mysqli_query($mysqli, "SELECT * FROM tipo_vehiculo
WHERE id_tpv='$id'");

if (mysqli_num_rows($query) < 0) {
    echo '<script>toastr.error("Tipo no existe")</script>';
    header("refresh: 1; url=listar.php");
} else {
    $sentencia = $mysqli->prepare("UPDATE tipo_vehiculo SET
estado_t = ?
WHERE id_tpv = ?");
    $sentencia->bind_param("si", $estado, $id);
    $sentencia->execute();
    echo '<script>toastr.error("Tipo Inactivo")</script>';
    header("refresh: 1; url=listar.php");
}
