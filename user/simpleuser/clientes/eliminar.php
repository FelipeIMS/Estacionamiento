
<?php
include_once "encabezado.php";
include "conexion.php";
$id = $_GET["id"];
$estado = 'Inactivo';
$estaoficha = 'No pagado';
$wea = mysqli_query($mysqli, "SELECT * FROM ficha
INNER JOIN vehiculo ON vehiculo.patente= ficha.patente
INNER JOIN cliente ON cliente.id_cliente = vehiculo.cliente
WHERE  ficha.estado='$estaoficha'  and cliente.id_cliente='$id'");

if (mysqli_num_rows($wea) > 0) {
    echo '<script>toastr.error("Cliente tiene ficha pendiente de pago ")</script>';
    header("refresh: 1; url=listar.php");
} else {
    $sentencia = $mysqli->prepare("UPDATE cliente SET
estado = ?
WHERE id_cliente = ?");
    $sentencia->bind_param("si", $estado, $id);
    $sentencia->execute();
    echo '<script>toastr.error("Cliente Inactivo")</script>';
    header("refresh: 1; url=listar.php");
}
