<?php
include_once "encabezado.php";
include '../settings.php'; 
$id = $_GET["id"];
$sentencia = $conn->prepare("SELECT * FROM tipo_vehiculo  WHERE id_tpv = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
# Obtenemos solo una fila, que será el CLIENTE a editar
$tipo = $resultado->fetch_assoc();
if (!$tipo) {
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
        <h1 class="text-center">Actualizar Tipo Vehiculo</h1>
        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $tipo["id_tpv"] ?>">
            <div class="form-group">
                <label for="nombre">Nombre marca</label>
                <input value="<?php echo $tipo["nombre_tpv"] ?>" placeholder="" class="form-control" type="text" name="tipo" id="tipo">
            </div>
            <div class="form-group">
                <label for="Default select example">Estado</label>
                <select class="form-select mb-3" aria-label="Default select example" id="estado_t" name="estado_t" value="<?php echo $tipo["estado_t"] ?>" disabled>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
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