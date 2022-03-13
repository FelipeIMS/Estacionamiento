<!DOCTYPE html>
<html lang="en">
<title>Generar reporte</title>
<?php include('header.php');
include('conexion.php');
$resultado2 = $mysqli->query("SELECT CONCAT(cliente.nombre_cliente,' ',cliente.apellido_cliente) as nombres, id_cliente FROM cliente");
$t2 = mysqli_num_rows($resultado2);
$resultadoVehiculo = $mysqli->query("SELECT * FROM vehiculo order by id_vehiculo asc");
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
    </div>
    <div class="container w-50">
        <form action="exportar_movXusu.php" method="POST">
            <div class="card text-center mt-5">
                <div class="card-header">Reporte: Por cliente</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Desde: </label>
                            <input type="date" name="date3" id="date3" required>
                            <label>Hasta: </label>
                            <input type="date" name="date4" id="date4" required>
                            <label for="descripcion">Cliente: </label>

                            <select  id="cliente" name="cliente">
                                <?php

                                if ($t2 >= 1) {

                                    ?>
                                        <option value="0">Escoja cliente</option>
                                    <?php
                                    while ($row = $resultado2->fetch_object()) {
                                ?>
                                        <option value="<?php echo $row->id_cliente ?>"><?php echo $row->nombres ?></option>
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
                            <input type="date" name="date5" id="date5" required>
                            <label>Hasta: </label>
                            <input type="date" name="date6" id="date6" required>
                            <label for="descripcion">Cliente: </label>

                            <select  id="patente" name="patente">
                                <?php

                                if ($tVehiculo >= 1) {

                                    ?>
                                        <option value="0">Escoja Patente</option>
                                    <?php
                                    while ($row = $resultadoVehiculo->fetch_object()) {
                                ?>
                                        <option value="<?php echo $row->id_vehiculo ?>"><?php echo $row->patente ?></option>
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







    <?php include('footer.php')?>
<script>
    var today = new Date().toISOString().split('T')[0];
    document.getElementById("date1").setAttribute('max', today);
    var today = new Date().toISOString().split('T')[0];
    document.getElementById("date2").setAttribute('max', today);
</script>
<script>
    var today = new Date().toISOString().split('T')[0];
    document.getElementById("date3").setAttribute('max', today);
    var today = new Date().toISOString().split('T')[0];
    document.getElementById("date4").setAttribute('max', today);
</script>
<script>
    var today = new Date().toISOString().split('T')[0];
    document.getElementById("date5").setAttribute('max', today);
    var today = new Date().toISOString().split('T')[0];
    document.getElementById("date6").setAttribute('max', today);
</script>

</body>

</html>