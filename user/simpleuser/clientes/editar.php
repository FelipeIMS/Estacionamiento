<?php
include_once "encabezado.php";
 include_once "settings.php";
$id = $_GET["id"];
$sentencia = $conn->prepare("SELECT * FROM cliente
INNER JOIN area on area.id_area = cliente.area
INNER JOIN convenios on convenios.id_convenio=cliente.convenio
INNER JOIN cargo on cargo.id_cargo = cliente.cargo
 WHERE id_cliente = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();

$resultado2 = $conn->query("SELECT * FROM area ORDER BY nombre_area");
$t2 = mysqli_num_rows($resultado2);

$resultado3 = $conn->query("SELECT * FROM convenios ORDER BY nombre_convenio");
$t3 = mysqli_num_rows($resultado3);

$resultado4 = $conn->query("SELECT * FROM cargo ORDER BY nombre_cargo");
$t4 = mysqli_num_rows($resultado4);
# Obtenemos solo una fila, que será el CLIENTE a editar
$cliente = $resultado->fetch_assoc();
if (!$cliente) {
    exit("No hay resultados para ese ID");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <h1 class="text-center">Actualizar Cliente</h1>
        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>">
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

                <select class="form-select" id="area" name="area" value="<?php echo $cliente['nombre_area'] ?>">
                    <option value="<?php echo $cliente['id_area'] ?>"><?php echo $cliente['nombre_area'] ?></option>
                    <?php
                    

                    if ($t2 > 0) {

                        ?>
                        <?php
                        while ($row = $resultado2->fetch_object()) {
                    ?>
                            <option value="<?php echo $row->id_area ?>"><?php echo $row->nombre_area ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
                
            </div>
            <div class="form-group mb-3">
                <label for="descripcion">Cargo</label>

                <select class="form-select" id="cargo" name="cargo">
                    <?php

                    if ($t4 >= 1) {

                        ?>
                            <option value="<?php echo $cliente['id_cargo'] ?>"><?php echo $cliente['nombre_cargo'] ?></option>
                        <?php
                        while ($row = $resultado4->fetch_object()) {
                    ?>
                            <option value="<?php echo $row->id_cargo ?>"><?php echo $row->nombre_cargo ?></option>
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

                <select class="form-select" id="convenio" name="convenio">
                    <option value="<?php echo $cliente['id_convenio'] ?>"><?php echo $cliente['nombre_convenio'] ?></option>
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
            <div class="form-group mb-3">
                      <label for="obs" class="form-label">Observacion</label>
                      <textarea class="form-control" name="obs" id="obs" rows="6" style="resize: none;"><?php echo $cliente['observacion']?></textarea>
                </div>
            <div class="form-group">
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-warning" href="listar.php">Volver</a>
            </div>
        </form>

    </div>
</body>
<?php include_once "pie.php"; ?>

</html>