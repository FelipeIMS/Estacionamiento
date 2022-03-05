
<?php
include_once "encabezado.php";

$mysqli = include_once "conexion.php";
$nombre = $_POST["nombreconvenio"];
$tiempo = $_POST["descuento"];


$buscarconvenio= mysqli_query($mysqli,"SELECT  * FROM convenios WHERE nombre_convenio='$nombre'");

if(mysqli_num_rows($buscarconvenio)>0){
    echo '<script>toastr.error("Convenio ya existe  ")</script>';
    header("refresh: 1; url=listar.php");
}else{
    $sentencia = $mysqli->prepare("INSERT INTO convenios
    (nombre_convenio,tiempo)
    VALUES
    (?,?)");
    $sentencia->bind_param("si",$nombre,$tiempo);
    $sentencia->execute();
    echo '<script>toastr.success("Registro OK ")</script>';
    header("refresh: 1; url=listar.php");
    
}
