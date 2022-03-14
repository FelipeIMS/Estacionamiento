<?php include_once "encabezado.php";
include '../settings.php'; 
?>

<?php

$precio = $_POST["precio"];

$sentencia = $conn->prepare("UPDATE precio SET
precio = ?,
f_implementacion = now()
WHERE id_precio = 1");
$sentencia->bind_param("i", $precio);
$sentencia->execute();
echo '<script>toastr.success("Precio Actualizado")</script>';
header("refresh: 1; url=../index/index.php");

?>



<?php include_once "pie.php"; ?>