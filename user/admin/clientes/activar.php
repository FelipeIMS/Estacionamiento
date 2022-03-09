
<?php
include_once "encabezado.php";
include '../settings.php'; 
$id = $_GET["id"];
$estaoficha = 'No pagado';
$estado = 'Activo';
$wea = mysqli_query($conn, "SELECT * FROM ficha
INNER JOIN vehiculo ON vehiculo.patente= ficha.patente
INNER JOIN cliente ON cliente.id_cliente = vehiculo.cliente
WHERE  ficha.estado='$estaoficha'  and cliente.id_cliente='$id'");

if (mysqli_num_rows($wea) > 0) {
    echo '<script>toastr.error("Pendiente")</script>';
    header("refresh: 1; url=listar.php");
} else {
    $sentencia = $conn->prepare("UPDATE cliente SET
estado = ?
WHERE id_cliente = ?");
    $sentencia->bind_param("si", $estado, $id);
    $sentencia->execute();
    echo '<script>toastr.success("Cliente Activo")</script>';
    header("refresh: 1; url=listar.php");
}
