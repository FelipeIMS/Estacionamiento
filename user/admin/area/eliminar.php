
<?php
include_once "encabezado.php";
include '../settings.php'; 
$id = $_GET["id"];
$estado = 'Inactivo';
$wea = mysqli_query($conn, "SELECT * FROM area WHERE id_area='$id'");

if (mysqli_num_rows($wea) < 0) {
    echo '<script>toastr.error("Area no existe")</script>';
    header("refresh: 1; url=listar.php");
} else {
    $sentencia = $conn->prepare("UPDATE area SET
estado_area = ?
WHERE id_area = ?");
    $sentencia->bind_param("si", $estado, $id);
    $sentencia->execute();
    echo '<script>toastr.error("Area Inactivo")</script>';
    header("refresh: 1; url=listar.php");
}
