
<?php
include_once "encabezado.php";
include '../settings.php'; 
$id = $_GET["id"];
$estado = 'Inactivo';
$wea = mysqli_query($conn, "SELECT * FROM vehiculo WHERE id_vehiculo='$id'");


if (mysqli_num_rows($wea) < 0) {
    echo '<script>toastr.error("ID no existe")</script>';
    header("refresh: 1; url=listar.php");
} else {
    $sentencia = $conn->prepare("UPDATE vehiculo SET
estado_v = ?
WHERE id_vehiculo = ?");
    $sentencia->bind_param("si", $estado, $id);
    $sentencia->execute();
    echo '<script>toastr.error("Vehiculo Inactivo")</script>';
    header("refresh: 1; url=listar.php");
}
