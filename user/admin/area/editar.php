<?php
include_once "encabezado.php";
include '../settings.php'; 
$id = $_GET["id"];
$sentencia = $conn->prepare("SELECT * FROM area  WHERE id_area = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
# Obtenemos solo una fila, que será el CLIENTE a editar
$area = $resultado->fetch_assoc();
if (!$area) {
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
        <h1 class="text-center">Actualizar Area</h1>
        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $area["id_area"] ?>">
            <div class="form-group">
                <label for="nombre">Area</label>
                <input value="<?php echo $area["nombre_area"] ?>" placeholder="" class="form-control" type="text" name="nombre_area" id="nombre_area" >
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