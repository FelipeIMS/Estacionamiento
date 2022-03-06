<?php
include_once "encabezado.php";
include 'settings.php';
$id = $_GET["id"];
$sentencia = $conn->prepare("SELECT * FROM cliente
INNER JOIN area on area.id_area = cliente.area
INNER JOIN convenios on convenios.id_convenio=cliente.convenio WHERE id_cliente = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();

$resultado2 = $conn->query("SELECT * FROM area ORDER BY id_area");
$t2 = mysqli_num_rows($resultado2);

$resultado3 = $conn->query("SELECT * FROM convenios ORDER BY id_convenio");
$t3 = mysqli_num_rows($resultado3);
# Obtenemos solo una fila, que será el CLIENTE a editar
$cliente = $resultado->fetch_assoc();
if (!$cliente) {
    exit("No hay resultados para ese ID");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Actualizar Cliente</h1>
        <form action="actualizar_cliente.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $cliente["id_cliente"] ?>">
            <div class="form-group">
                <label for="nombre">RUT</label>
                <input value="<?php echo $cliente["rut"] ?>" placeholder="" class="form-control" type="text" name="rut" id="rut" disabled>
            </div>
            <div class="form-group">
                <label for="descripcion">Nombres</label>
                <input value="<?php echo $cliente["nombre_cliente"] ?>" placeholder="" class="form-control" type="text" name="nombre" id="nombre">

            </div>
            <div class="form-group">
                <label for="descripcion">Apelidos</label>
                <input value="<?php echo $cliente["apellido_cliente"] ?>" placeholder="" class="form-control" type="text" name="apellidos" id="apellidos">
            </div>
            <div class="form-group mb-3">
                <label for="descripcion">Area</label>

                <select class="form-select" id="area" name="area" value="<?php echo $cliente["area"] ?>">
                    <?php

                    if ($t2 >= 1) {
                        while ($row = $resultado2->fetch_object()) {
                    ?>
                            <option value="<?php echo $row->id_area ?>"><?php echo $row->nombre_area ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Default select example">Estado</label>
                <select class="form-select mb-3" aria-label="Default select example" id="estado" name="estado" value="<?php echo $cliente["estado"] ?>" disabled>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="descripcion">Convenio</label>

                <select class="form-select" value="<?php echo $cliente["convenio"] ?>" id="convenio" name="convenio" >
                    <?php
                    if ($t3 >= 1) {
                        while ($row = $resultado3->fetch_object()) {
                    ?>
                            <option value="<?php echo $row->id_convenio ?>"><?php echo $row->nombre_convenio ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-warning" href="listar_cliente.php">Volver</a>
            </div>
        </form>

    </div>
</body>
<?php include_once "pie.php"; ?>

</html>