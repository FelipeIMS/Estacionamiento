<?php
include '../settings.php';
include 'consultas.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Estadisticas Estacionamiento Clinica Lircay</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
</head>

<script>
    $(function() {


        var data_viewer = <?php echo $viewer; ?>;
        var data2 = <?php echo $viewer2; ?>;
        var terminoid = <?php echo $terminoid; ?>;
        var terminoval = <?php echo $terminoval; ?>;


        $('#container').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Entradas y Salidas de los ultimos 7 dias'
            },
            xAxis: {
                categories: data_viewer
            },
            yAxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            series: [{
                name: 'Entrada',
                data: data2
            }, {
                name: 'Salida',
                data: terminoval
            }]
        });
    });
</script>
<script>
    $(function() {


        var terminoid = <?php echo $terminoid; ?>;
        var terminoval = <?php echo $terminoval; ?>;


        $('#salidas').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Salidas de los ultimos 7 dias'
            },
            xAxis: {

                categories: terminoid
            },
            yAxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            series: [{
                name: 'Cantidad',
                data: terminoval
            }]
        });
    });
</script>

<script>
    $(function() {


        var mesid = <?php echo $mesid; ?>;
        var mesval = <?php echo $mesval; ?>;


        $('#pordia').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Ingresos por dia'
            },
            xAxis: {

                categories: mesid
            },
            yAxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            series: [{
                name: 'Cantidad',
                data: mesval
            }]
        });
    });
</script>
<script>
    $(function() {
        var userid = <?php echo $userid; ?>;
        var userval = <?php echo $userval; ?>;
        var username = <?php echo $username; ?>;

        var userval2 = <?php echo $userval2; ?>;
        var username2 = <?php echo $username2; ?>;

        $('#cajeros').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Ingresos ultimos 30 dias'
            },
            xAxis: {
                categories: userid
            },
            yAxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            series: [{
                name: username[0],
                data: userval
            }, {
                name: username2[0],
                data: userval2
            }]
        });
    });
</script>

<body>

    <?php


    $date1 = isset($_POST['date1']) ? $_POST['date1'] : "";
    $date2 = isset($_POST['date2']) ? $_POST['date2'] : "";
    $datenew = isset($_POST['datenew']) ? $_POST['datenew'] : "";
    $datenew2 = isset($_POST['datenew2']) ? $_POST['datenew2'] : "";
    $user = isset($_POST['postName']) ? $_POST['postName'] : "";

    $conn->query("SET lc_time_names = 'es_ES'");
    $sql = "SELECT DAY(fecha_pago) Mes, SUM(total) total_mes
    FROM ficha
    WHERE fecha_pago and fecha_pago between '$date1' and '$date2'
    GROUP BY Mes
     ORDER BY Mes";
    $query = $conn->query($sql); // Ejecutar la consulta SQL
    $data = array(); // Array donde vamos a guardar los datos
    while ($r = $query->fetch_object()) { // Recorrer los resultados de Ejecutar la consulta SQL
        $data[] = $r; // Guardar los resultados en la variable $data
    }

    $sql2 = "SELECT DAY(fecha_pago) DIA,SUM(total) total_dia,users.name as user_venta FROM ficha
    INNER JOIN users ON users.id = ficha.user_ficha_out
    WHERE WEEK(fecha_pago)= WEEK(CURDATE()) AND
    fecha_pago BETWEEN '$datenew' and '$datenew2'
    AND
    ficha.user_ficha_out='$user'
    GROUP BY DIA,DAYNAME(fecha_pago)
    ORDER BY fecha_pago";

    /*    $sql2 = "SELECT DAY(inicio) Mes, SUM(total) total_dia,users.name as user_venta
    FROM ficha
    INNER JOIN users ON users.id = ficha.user_ficha_out
    WHERE ficha.inicio and ficha.termino between '$datenew' and '$datenew2' AND
    ficha.user_ficha_out='$user'
    GROUP BY Mes";
 */


    $query2 = $conn->query($sql2); // Ejecutar la consulta SQL
    $data2 = array(); // Array donde vamos a guardar los datos
    while ($r = $query2->fetch_object()) { // Recorrer los resultados de Ejecutar la consulta SQL
        $data2[] = $r; // Guardar los resultados en la variable $data

    }


    ?>


    <style>
        .d-flex {
            margin-top: 1.9em;
        }
    </style>
     <div class="container">
        <br />
        <h2 class="text-center">Movimientos cajeros</h2>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        <div id="cajeros"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <br />
        <h2 class="text-center">Entradas y Salidas </h2>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        <div id="container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <br />
        <h2 class="text-center">Ingresos por dias</h2>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body" style="margin-left: 400px; width: 1000px;">
                        <form method="post">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Desde: </label>
                                        <input class="form-control" type="datetime-local" id="datenew" name="datenew" value=<?php echo date('Y-m-d\TH:i:s'); ?> required>

                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Hasta: </label>
                                        <input class="form-control" type="datetime-local" id="datenew2" name="datenew2" value=<?php echo date('Y-m-d\TH:i:s'); ?> required>
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="d-flex justify-content-around my-4">
                                        <button class="btn btn-sm btn-outline-secondary btn-bottom-left" type="submit">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div id="pordia"></div>

                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <h1 class="text-center">Movimientos por usuario</h1>
        <form method="post" class="text-center">
            <a class="btn btn-warning my-2" style="float:right" href="../index/index.php"><i class="fa-solid fa-arrow-left"></i></a>

            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="fs7 m-0 text-secondary">
                            Cajero
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-control postName" id="postName" name="postName">
                            <option value="0" selected disabled>Selecciona un cliente</option>
                        </select>

                    </div>

                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Desde: </label>
                        <input class="form-control" type="datetime-local" id="datenew" name="datenew" value=<?php echo date('Y-m-d\TH:i:s'); ?> required>

                    </div>

                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Hasta: </label>
                        <input class="form-control" type="datetime-local" id="datenew2" name="datenew2" value=<?php echo date('Y-m-d\TH:i:s'); ?> required>
                    </div>

                </div>
                <div class="col-sm-3">
                    <div class="d-flex justify-content-around my-4">
                        <button class="btn btn-sm btn-outline-secondary btn-bottom-left" type="submit">
                            <i class="fas fa-search"></i> Buscar
                        </button>

                    </div>
                </div>
            </div>


        </form>
        <canvas id="chart2"></canvas>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <!--   <script>
        var ctx = document.getElementById("chart1");
        var data = {
            labels: [
                <?php foreach ($data as $d) : ?> "<?php echo $d->Mes ?>",
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Ingresos por Dia',
                data: [
                    <?php foreach ($data as $d) : ?>
                        <?php echo $d->total_mes; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
            }]
        };
        var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };
        var chart1 = new Chart(ctx, {
            type: 'line',
            /* valores: line, bar*/
            data: data,
            options: options
        });
    </script> -->
    <!--  <script>
        document.getElementById("date1").addEventListener("input", () => console.log(document.getElementById("date1").value));
        document.getElementById("date2").addEventListener("input", () => console.log(document.getElementById("date2").value));
    </script> -->
    <script>
        $('.postName').select2({
            placeholder: 'Seleccionar un cliente',
            ajax: {
                url: 'select.php',
                dataType: 'json',
                delay: 250,
                data: function(data) {
                    return {
                        searchTerm: data.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    </script>



</body>

</html>