
<?php
include_once "encabezado.php";
include '../settings.php';
$id = $_GET["id"];
$estado = 'Inactivo';
$query = mysqli_query($conn, "SELECT * FROM cargo
WHERE id_cargo='$id'");

if (mysqli_num_rows($query) < 0) {
    echo '<script>toastr.error("Cargo no existe")</script>';
    header("refresh: 1; url=listar.php");
} else {
    $sentencia = $conn->prepare("UPDATE cargo SET
estado_c = ?
WHERE id_cargo = ?");
    $sentencia->bind_param("si", $estado, $id);
    $sentencia->execute();
    echo '<script>toastr.error("Cargo Inactivo")</script>';
    header("refresh: 1; url=listar.php");
}
