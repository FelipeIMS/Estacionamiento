
<?php
include_once "encabezado.php";
$mysqli = include_once "conexion.php";
$rut = $_POST["rut"];
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$area = $_POST["area"];
$estado = $_POST["estado"];
$convenio = $_POST["convenio"];
$cargo = $_POST["cargo"];
$obs = $_POST["obs"];

if (!empty($_POST)) {
    
    $resultado = $mysqli->query("SELECT * FROM cliente  WHERE concat(nombre_cliente,' ',apellido_cliente) = '".$nombre."".' '."".$apellidos."';");
    if (mysqli_num_rows($resultado) > 0) {
        echo '<script>toastr.error("Cliente ya existe")</script>';
        header("refresh: 1; url=formulario_registrar.php");
    }else{
        $sentencia = $mysqli->prepare("INSERT INTO cliente
        (rut, nombre_cliente,apellido_cliente,area,estado,convenio,cargo, observacion)
        VALUES
        (?, ?,?,?,?,?,?,?)");
        $sentencia->bind_param("ssssssss", $rut, $nombre, $apellidos, $area, $estado, $convenio,$cargo,$obs);
        $sentencia->execute();
        echo '<script>toastr.success("Cliente Registrado")</script>';
        header("refresh: 1; url=listar.php");
    }

}


