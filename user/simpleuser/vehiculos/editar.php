<?php
include_once "encabezado.php";
$mysqli = include_once "conexion.php";
$id = $_GET["id"];
$sentencia = $mysqli->prepare("SELECT *, concat(cliente.nombre_cliente,' ',cliente.apellido_cliente) n, vehiculo.observacion as obs FROM vehiculo
INNER JOIN marca_vehiculo ON marca_vehiculo.id_mv=vehiculo.marca_vehiculo
INNER JOIN tipo_vehiculo ON tipo_vehiculo.id_tpv = vehiculo.tipo_vehiculo
INNER JOIN cliente ON  cliente.id_cliente=vehiculo.cliente  WHERE id_vehiculo = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();

$resultado1 = $mysqli->query("SELECT * FROM tipo_vehiculo ORDER BY nombre_tpv");
$t = mysqli_num_rows($resultado1);
$resultado2 = $mysqli->query("SELECT * FROM marca_vehiculo ORDER BY nombre_marca");
$t2 = mysqli_num_rows($resultado2);

$resultado3 = $mysqli->query("SELECT * FROM cliente ORDER BY nombre_cliente");
$t3 = mysqli_num_rows($resultado3);
# Obtenemos solo una fila, que será el CLIENTE a editar
$vehiculo = $resultado->fetch_assoc();
if (!$vehiculo) {
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
        <h1 class="text-center">Actualizar Vehiculo</h1>
        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $vehiculo["id_vehiculo"] ?>">
            <div class="form-group">
                <label for="nombre">Patente</label>
                <input value="<?php echo $vehiculo["patente"] ?>" placeholder="" class="form-control" type="text" name="patente" id="patente"  >
            </div>
            <div class="form-group mb-3">
                <label for="descripcion">Tipo Vehiculo</label>

                <select class="form-select" id="tipo" name="tipo">
                    <?php
                    if ($t >= 1) {
                        ?>
                        <option value="<?php echo $vehiculo['id_tpv'] ?>"><?php echo $vehiculo['nombre_tpv'] ?></option>
                        <?php

                        while ($row = $resultado1->fetch_object()) {
                    ?>
                            <option value="<?php echo $row->id_tpv ?>"><?php echo $row->nombre_tpv ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="descripcion">Marca</label>

                <select class="form-select" id="marca" name="marca">
                    <?php

                    if ($t2 >= 1) {
                        ?>
                        <option value="<?php echo $vehiculo['id_mv'] ?>"><?php echo $vehiculo['nombre_marca'] ?></option>
                        <?php
                        while ($row = $resultado2->fetch_object()) {
                    ?>
                            <option value="<?php echo $row->id_mv ?>"><?php echo $row->nombre_marca ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="descripcion">Cliente</label>

                <select class="form-select" id="cliente" name="cliente" disabled>
                    <?php

                    if ($t3 >= 1) {
                        ?>
                        <option value="0"><?php echo $vehiculo['n'] ?></option>
                    <?php
                        while ($row = $resultado3->fetch_object()) {
                    ?>
                            <option value="<?php echo $row->id_cliente ?>"><?php echo $row->nombre_cliente ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mb-3">
                      <label for="obs" class="form-label">Observacion</label>
                      <textarea class="form-control" name="obs" id="obs" rows="6" style="resize: none;"><?php echo $vehiculo['obs']?></textarea>
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