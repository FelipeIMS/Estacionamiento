
<?php
      include_once "encabezado.php";

$mysqli = include_once "conexion.php";
$area = $_POST["area"];


if (!empty($_POST)) {
    $resultado = $mysqli->query("SELECT * FROM AREA  WHERE nombre_area ='$area'");
    if (mysqli_num_rows($resultado) > 0) {
        echo '<script>toastr.error("Area ya existe")</script>';
        header("refresh: 1; url=listar.php");
    } else {
        $sentencia = $mysqli->prepare("INSERT INTO area
        (nombre_area)
        VALUES
        (?)");
        $sentencia->bind_param("s", $area);
        $sentencia->execute();
        echo '<script>toastr.success("Registro OK")</script>';
        header("refresh: 1; url=listar.php");
    }
}
