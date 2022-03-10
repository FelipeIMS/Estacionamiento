
<?php
include_once "encabezado.php";

include '../settings.php';
$cargo = $_POST["cargo"];
$estado = $_POST["estado_c"];


$buscarmarca= mysqli_query($conn,"SELECT  * FROM cargo WHERE nombre_cargo='$cargo'");

if(mysqli_num_rows($buscarmarca)>0){
    echo '<script>toastr.error("Cargo ya existe  ")</script>';
    header("refresh: 1; url=listar.php");
}else{
    $sentencia = $conn->prepare("INSERT INTO cargo
    (nombre_cargo,estado_c)
    VALUES
    (?,?)");
    $sentencia->bind_param("ss",$cargo,$estado);
    $sentencia->execute();
    echo '<script>toastr.success("Registro OK ")</script>';
    header("refresh: 1; url=listar.php");
    
}
