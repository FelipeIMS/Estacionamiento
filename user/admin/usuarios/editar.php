<?php
include_once "encabezado.php";
include '../settings.php';
$id = $_GET["id"];
$sentencia = $conn->prepare("SELECT * FROM users  WHERE id = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
# Obtenemos solo una fila, que será el CLIENTE a editar
$user = $resultado->fetch_assoc();
if (!$user) {
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
        <h1 class="text-center">Actualizar Usuario</h1>
        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $user["id"] ?>">
            <div class="form-group">
                <label for="nombre">Username</label>
                <input value="<?php echo $user["name"] ?>" placeholder="" class="form-control" type="text" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="nombre">Login Email</label>
                <input value="<?php echo $user["login"] ?>" placeholder="" class="form-control" type="text" name="login" id="login">
            </div>
            <div class="form-group">
                <label for="nombre">Rol</label>
                <input value="<?php echo $user["role"] ?>" placeholder="" class="form-control" type="text" name="role" id="role">
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