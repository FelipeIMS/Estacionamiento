<!DOCTYPE html>
<html lang="en">
<title>Generar reporte</title>
<?php include('header.php');
include('settings.php');
$resultado2 = $conn->query("SELECT CONCAT(cliente.nombre_cliente,' ',cliente.apellido_cliente) as nombres FROM cliente ORDER BY nombre_cliente");
$t2 = mysqli_num_rows($resultado2);
$resultadoVehiculo = $conn->query("SELECT * FROM vehiculo");
$tVehiculo = mysqli_num_rows($resultadoVehiculo);
?>

<body>
    <div class="container w-50">
        <form action="exportar.php" method="POST">
            <div class="card text-center mt-5">
                <div class="card-header">Reporte: General</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Desde: </label>
                            <input type="date" name="date1" id="date1" required>
                            <label>Hasta: </label>
                            <input type="date" name="date2" id="date2" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <button type="submit" class="btn btn-success" name="enviar">Generar</button>
                    <a href="index.php" class="btn btn-info">Volver</a>
                </div>
            </div>
        </form>
    <!-- </div>
    <div class="container w-50">
        <form action="exportar_total.php" method="POST">
            <div class="card text-center mt-5">
                <div class="card-header">Reporte: Total Generado</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Desde: </label>
                            <input type="date" name="date1" id="date1" required>
                            <label>Hasta: </label>
                            <input type="date" name="date2" id="date2" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <button type="submit" class="btn btn-success" name="enviar">Generar</button>
                    <a href="index.php" class="btn btn-info">Volver</a>
                </div>
            </div>
        </form>
    </div>
    <div class="container w-50">
        <form action="exportar_movXusu.php" method="POST">
            <div class="card text-center mt-5">
                <div class="card-header">Reporte: Por cliente</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Desde: </label>
                            <input type="date" name="date1" id="date1" required>
                            <label>Hasta: </label>
                            <input type="date" name="date2" id="date2" required>
                            <label for="descripcion">Cliente: </label>

                            <select  id="cliente" name="cliente">
                                <?php

                                if ($t2 >= 1) {

                                    ?>
                                        <option value="0">Escoja cliente</option>
                                    <?php
                                    while ($row = $resultado2->fetch_object()) {
                                ?>
                                        <option value="<?php echo $row->nombres ?>"><?php echo $row->nombres ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <button type="submit" class="btn btn-success" name="enviar">Generar</button>
                    <a href="index.php" class="btn btn-info">Volver</a>
                </div>
            </div>
        </form>
    </div>
    <div class="container w-50">
        <form action="exportar_fichaXpatente.php" method="POST">
            <div class="card text-center mt-5">
                <div class="card-header">Reporte: Por Patente</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Desde: </label>
                            <input type="date" name="date1" id="date1" required>
                            <label>Hasta: </label>
                            <input type="date" name="date2" id="date2" required>
                            <label for="descripcion">Cliente: </label>

                            <select  id="patente" name="patente">
                                <?php

                                if ($tVehiculo >= 1) {

                                    ?>
                                        <option value="0">Escoja Patente</option>
                                    <?php
                                    while ($row = $resultadoVehiculo->fetch_object()) {
                                ?>
                                        <option value="<?php echo $row->patente ?>"><?php echo $row->patente ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <button type="submit" class="btn btn-success" name="enviar">Generar</button>
                    <a href="index.php" class="btn btn-info">Volver</a>
                </div>
            </div>
        </form>
    </div> -->







    <?php include('footer.php')?>

</body>

</html>