<?php
include_once "encabezado.php";
$mysqli = include_once "conexion.php";
$resultado = $mysqli->query("SELECT * FROM area");
$areas = $resultado->fetch_all(MYSQLI_ASSOC);
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Listado de Areas</h1>
            <a class="btn btn-success my-2" href="formulario_registrar.php"><i class="fa-solid fa-plus"></i></a>
            <a class="btn btn-warning my-2" style="float:right" href="../index.php"><i class="fa-solid fa-arrow-left"></i></a>


        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>ID</th>
                    <th>Area</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($areas as $area) { ?>
                    <tr>
                    <td>
                            <a class="btn btn-warning" href="editar.php?id=<?php echo $area["id_area"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a class="btn btn-danger" href="eliminar.php?id=<?php echo $area["id_area"] ?>"><i class="fa-solid fa-trash"></i></a>

                        </td>
                        <td><?php echo $area["id_area"] ?></td>
                        <td><?php echo $area["nombre_area"] ?></td>
                   
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once "pie.php" ?>