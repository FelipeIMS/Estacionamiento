
<?php
include_once "encabezado.php";
include '../settings.php';
$id = $_GET["id"];
$wea = mysqli_query($conn, "SELECT * FROM area
WHERE id_area='$id'");
$estado_area='Activo';
if (mysqli_num_rows($wea) < 0) {
    echo '<script>toastr.error("No existe")</script>';
    header("refresh: 1; url=listar.php");
} else {
    $sentencia = $conn->prepare("UPDATE area SET
estado_area= ?
WHERE id_area = ?");
    $sentencia->bind_param("si", $estado_area, $id);
    $sentencia->execute();
    echo '<script>toastr.success("Area Activo")</script>';
    header("refresh: 1; url=listar.php");
}
