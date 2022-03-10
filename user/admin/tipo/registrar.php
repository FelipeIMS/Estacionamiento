
<?php
include_once "encabezado.php";

include '../settings.php'; 
$tipo = $_POST["tipo"];
$estado = $_POST["estado_t"];


$buscartipo= mysqli_query($conn,"SELECT  * FROM tipo_vehiculo WHERE nombre_tpv='$tipo'");

if(mysqli_num_rows($buscartipo)>0){
    echo '<script>toastr.error("Tipo ya existe  ")</script>';
    header("refresh: 1; url=listar.php");
}else{
    $sentencia = $conn->prepare("INSERT INTO tipo_vehiculo
    (nombre_tpv,estado_t)
    VALUES
    (?,?)");
    $sentencia->bind_param("ss",$tipo,$estado);
    $sentencia->execute();
    echo '<script>toastr.success("Registro OK ")</script>';
    header("refresh: 1; url=listar.php");
    
}
