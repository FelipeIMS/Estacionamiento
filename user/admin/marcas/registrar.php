
<?php
include_once "encabezado.php";

$mysqli = include_once "conexion.php";
$marca = $_POST["marca"];
$estado = $_POST["estado_m"];


$buscarmarca= mysqli_query($mysqli,"SELECT  * FROM marca_vehiculo WHERE nombre_marca='$marca'");

if(mysqli_num_rows($buscarmarca)>0){
    echo '<script>toastr.error("Marca ya existe  ")</script>';
    header("refresh: 1; url=listar.php");
}else{
    $sentencia = $mysqli->prepare("INSERT INTO marca_vehiculo
    (nombre_marca,estado_m)
    VALUES
    (?,?)");
    $sentencia->bind_param("ss",$marca,$estado);
    $sentencia->execute();
    echo '<script>toastr.success("Registro OK ")</script>';
    header("refresh: 1; url=listar.php");
    
}
