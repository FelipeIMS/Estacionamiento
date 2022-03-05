<?php
include_once "encabezado.php";
$mysqli = include_once "conexion.php";
$resultado = $mysqli->query("SELECT * FROM cliente
INNER JOIN area on area.id_area = cliente.area
INNER JOIN convenios on convenios.id_convenio=cliente.convenio");
$clientes = $resultado->fetch_all(MYSQLI_ASSOC);
?>
<div class="container">


    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Listado de Clientes</h1>
        </div>
        <div class="col-12">
            <a class="btn btn-success my-2" href="formulario_registrar.php"><i class="fa-solid fa-plus"></i></a>
            <a class="btn btn-warning my-2" style="float:right" href="../index.php"><i class="fa-solid fa-arrow-left"></i></a>
            <table class="table">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>#</th>
                        <th>RUT</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Area</th>
                        <th>Estado</th>
                        <th>Convenio</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($clientes as $cliente) { ?>
                        <tr>
                            <td>

                                <?php if ($cliente["estado"] == "Activo") { ?>
                                    <a class="btn btn-danger" href="eliminar.php?id=<?php echo $cliente["id_cliente"] ?>"><i class="fa-solid fa-circle-xmark"></i></i></a>

                                <?php } ?>
                                <?php if ($cliente["estado"] == "Inactivo") { ?>
                                    <a class="btn btn-success" href="activar.php?id=<?php echo $cliente["id_cliente"] ?>"><i class="fa-solid fa-check"></i></a>

                                <?php } ?>

                                <a class="btn btn-warning" href="editar.php?id=<?php echo $cliente["id_cliente"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>

                            </td>

                            <td><?php echo $cliente["id_cliente"] ?></td>
                            <td><?php echo $cliente["rut"] ?></td>
                            <td><?php echo $cliente["nombre_cliente"] ?></td>
                            <td><?php echo $cliente["apellido_cliente"] ?></td>
                            <td><?php echo $cliente["nombre_area"] ?></td>
                            <td><?php echo $cliente["estado"] ?></td>
                            <td><?php echo $cliente["nombre_convenio"] ?></td>


                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once "pie.php" ?>