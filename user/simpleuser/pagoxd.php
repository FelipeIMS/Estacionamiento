<?php
include 'settings.php';

$id = $_POST["id"];
$pago = $_POST["total"];
echo $pago;
$sentencia = $conn->prepare("UPDATE ficha SET
total = ?
WHERE id_ficha = ?");
$sentencia->bind_param("ii", $pago, $id);
$sentencia->execute();
header("Location: index.php");
