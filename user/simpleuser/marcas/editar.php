<?php
include_once "encabezado.php";
$mysqli = include_once "conexion.php";
$id = $_GET["id"];
$sentencia = $mysqli->prepare("SELECT * FROM convenios  WHERE id_convenio = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
# Obtenemos solo una fila, que será el CLIENTE a editar
$convenio = $resultado->fetch_assoc();
if (!$convenio) {
    exit("No hay resultados para ese ID");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <h1 class="text-center">Actualizar Convenio</h1>
        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $convenio["id_convenio"] ?>">
            <div class="form-group">
                <label for="nombre">Nombre Convenio</label>
                <input value="<?php echo $convenio["nombre_convenio"] ?>" placeholder="" class="form-control" type="text" name="convenio" id="convenio" >
            </div>
            <div class="form-group">
                <label for="nombre">% Descuento</label>
                <input value="<?php echo $convenio["tiempo"] ?>" placeholder="" class="form-control" type="text" name="tiempo" id="tiempo" >
            </div>
            <div class="form-group py-3">
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-warning" href="listar.php">Volver</a>
            </div>
        </form>

    </div>
</body>
<?php include_once "pie.php"; ?>

</html>