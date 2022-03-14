<!DOCTYPE html>
<html lang="en">
<title>Generar reporte</title>
<?php
include '../settings.php';
$resultado2 = $conn->query("SELECT CONCAT(cliente.nombre_cliente,' ',cliente.apellido_cliente) as nombres, id_cliente FROM cliente");
$t2 = mysqli_num_rows($resultado2);
$resultadoVehiculo = $conn->query("SELECT * FROM vehiculo order by id_vehiculo asc");
$tVehiculo = mysqli_num_rows($resultadoVehiculo);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

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

                            <select id="cliente" name="cliente">
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

                            <select id="patente" name="patente">
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