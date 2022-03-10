<?php
include_once "encabezado.php";
include '../settings.php';
$id = $_GET["id"];
$sentencia = $conn->prepare("SELECT * FROM cargo  WHERE id_cargo = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
# Obtenemos solo una fila, que será el CLIENTE a editar
$cargo = $resultado->fetch_assoc();
if (!$cargo) {
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
        <h1 class="text-center">Actualizar Cargo</h1>
        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $cargo["id_cargo"] ?>">
            <div class="form-group">
                <label for="nombre">Nombre Cargo</label>
                <input value="<?php echo $cargo["nombre_cargo"] ?>" placeholder="" class="form-control" type="text" name="cargo" id="cargo" >
            </div>
            <div class="form-group py-3">
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-warning" style="float:right" href="listar.php">Volver</a>
            </div>
        </form>

    </div>
</body>
<?php include_once "pie.php"; ?>

</html>