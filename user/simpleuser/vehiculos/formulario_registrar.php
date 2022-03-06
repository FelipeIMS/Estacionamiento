<?php include_once "encabezado.php";
$mysqli = include_once "conexion.php";
$resultado = $mysqli->query("SELECT * FROM tipo_vehiculo ORDER BY nombre_tpv");
$t = mysqli_num_rows($resultado);
$resultado2 = $mysqli->query("SELECT * FROM marca_vehiculo ORDER BY nombre_marca");
$t2 = mysqli_num_rows($resultado2);

$resultado3 = $mysqli->query("SELECT * FROM cliente ORDER BY nombre_cliente");
$t3 = mysqli_num_rows($resultado3);
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Registrar Vehiculo</h1>
            <form action="registrar.php" method="POST">
                <div class="form-group mb-3">
                    <label for="nombre">Patente</label>
                    <input placeholder="" class="form-control" type="text" name="patente" id="patente"   minlength="9" maxlength="8" size="10" required>
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Tipo Vehiculo</label>

                    <select class="form-select" id="tipo" name="tipo" required>
                        <?php

                        if ($t >= 1) {
                            while ($row = $resultado->fetch_object()) {
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

                    <select class="form-select" id="marca" name="marca" required>
                        <?php

                        if ($t2 >= 1) {
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

                    <select class="form-select" id="cliente" name="cliente" required>
                        <?php

                        if ($t3 >= 1) {
                            while ($row = $resultado3->fetch_object()) {
                        ?>
                                <option value="<?php echo $row->id_cliente ?>"><?php echo $row->nombre_cliente ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <button class="btn btn-success">Guardar</button>
                    <a href="listar.php" class="btn btn-warning" style="float: right;">Volver</a>
                </div>


            </form>
        </div>
    </div>
</div>




<?php include_once "pie.php"; ?>