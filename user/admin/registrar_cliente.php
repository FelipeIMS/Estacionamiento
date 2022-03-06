
<?php
include 'settings.php';
include_once "encabezado.php";
$rut = $_POST["rut"];
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$area = $_POST["area"];
$estado = $_POST["estado"];
$convenio = $_POST["convenio"];

    $siexiste = mysqli_query($conn,"SELECT * FROM cliente WHERE nombre_cliente='$nombre'");
    if (mysqli_num_rows($siexiste) > 0) {
        echo '<script>toastr.error("Cliente ya existe")</script>';
        header("refresh: 1; url=form_cliente.php");
    }else{
        echo"aca";
        $sentencia = $conn->prepare("INSERT INTO cliente
        (rut, nombre_cliente,apellido_cliente,area,estado,convenio)
        VALUES
        (?, ?,?,?,?,?)");
        $sentencia->bind_param("ssssss", $rut, $nombre, $apellidos, $area, $estado, $convenio);
        $sentencia->execute();
        echo '<script>toastr.success("Cliente Registrado")</script>';
        header("refresh: 1; url=listar_cliente.php");
    }




