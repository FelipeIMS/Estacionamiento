
<?php
include_once "encabezado.php";
include '../settings.php'; 
$rut = $_POST["rut"];
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$area = $_POST["area"];
$estado = $_POST["estado"];
$convenio = $_POST["convenio"];
$cargo = $_POST["cargo"];

if (!empty($_POST)) {
    
    $resultado = $conn->query("SELECT * FROM cliente  WHERE nombre_cliente ='$nombre'");
    if (mysqli_num_rows($resultado) > 0) {
        echo '<script>toastr.error("Cliente ya existe")</script>';
        header("refresh: 1; url=formulario_registrar.php");
    }else{
        $sentencia = $conn->prepare("INSERT INTO cliente
        (rut, nombre_cliente,apellido_cliente,area,estado,convenio,cargo)
        VALUES
        (?, ?,?,?,?,?,?)");
        $sentencia->bind_param("sssssss", $rut, $nombre, $apellidos, $area, $estado, $convenio,$cargo);
        $sentencia->execute();
        echo '<script>toastr.success("Cliente Registrado")</script>';
        header("refresh: 1; url=listar.php");
    }

}


