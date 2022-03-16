<?php
include '../settings.php';
date_default_timezone_set("America/Santiago");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Reporte por Mes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
</head>
</head>

<body>

    <?php


    $date1 = isset($_POST['date1']) ? $_POST['date1'] : "";
    $date2 = isset($_POST['date2']) ? $_POST['date2'] : "";
    $datenew = isset($_POST['datenew']) ? $_POST['datenew'] : "";
    $datenew2 = isset($_POST['datenew2']) ? $_POST['datenew2'] : "";
    $user = isset($_POST['postName']) ? $_POST['postName'] : "";

    $conn->query("SET lc_time_names = 'es_ES'");
    $sql = "SELECT DAY(inicio) Mes, SUM(total) total_mes
    FROM ficha
    WHERE inicio and termino between '$date1' and '$date2'
    GROUP BY Mes
     ORDER BY Mes";
    $query = $conn->query($sql); // Ejecutar la consulta SQL
    $data = array(); // Array donde vamos a guardar los datos
    while ($r = $query->fetch_object()) { // Recorrer los resultados de Ejecutar la consulta SQL
        $data[] = $r; // Guardar los resultados en la variable $data
    }


    $sql2 = "SELECT DAY(inicio) Mes, SUM(total) total_dia,users.name as user_venta
    FROM ficha
    INNER JOIN users ON users.id = ficha.user_ficha_out
    WHERE ficha.inicio and ficha.termino between '$datenew' and '$datenew2' AND
    ficha.user_ficha_out='$user'
    GROUP BY Mes";



    $query2 = $conn->query($sql2); // Ejecutar la consulta SQL
    $data2 = array(); // Array donde vamos a guardar los datos
    while ($r = $query2->fetch_object()) { // Recorrer los resultados de Ejecutar la consulta SQL
        $data2[] = $r; // Guardar los resultados en la variable $data

    }

    $sql3 = "SELECT DAY(inicio) DIA,COUNT(inicio) REGISTROS FROM ficha
    WHERE WEEK(inicio)= WEEK(CURDATE()) AND
    inicio BETWEEN date_add(NOW(), INTERVAL -6 DAY) AND NOW()
    GROUP BY DIA,DAYNAME(inicio)
    ORDER BY inicio";
    $query3 = $conn->query($sql3); // Ejecutar la consulta SQL
    $data3 = array(); // Array donde vamos a guardar los datos
    while ($r = $query3->fetch_object()) { // Recorrer los resultados de Ejecutar la consulta SQL
        $data3[] = $r; // Guardar los resultados en la variable $data

    }

    $sql4 = "SELECT DAY(termino) DIA,COUNT(termino) REGISTROS FROM ficha
    WHERE WEEK(termino)= WEEK(CURDATE()) AND
    termino BETWEEN date_add(NOW(), INTERVAL -6 DAY) AND NOW()
    GROUP BY DIA,DAYNAME(termino)
    ORDER BY termino";
    $query4 = $conn->query($sql4);
    $data4 = array(); // Array donde vamos a guardar los datos
    while ($r = $query4->fetch_object()) { // Recorrer los resultados de Ejecutar la consulta SQL
        $data4[] = $r; // Guardar los resultados en la variable $data

    }

    ?>


    <style>
        .d-flex {
            margin-top: 1.9em;
        }
    </style>

    <div class="container">
        <h1 class="text-center">Ingresos Por Mes</h1>
        <form method="post" class="text-center">

            <label>Desde: </label>
            <input type="datetime-local" id="date1" name="date1" value=<?php echo date('Y-m-d\TH:i:s'); ?> required>
            <label>Hasta: </label>
            <input type="datetime-local" id="date2" name="date2" value=<?php echo date('Y-m-d\TH:i:s'); ?> required>
            <button class="btn btn-success" type="submit">Generar</button>

        </form>
        <a class="btn btn-warning my-2" style="float:right" href="../index/index.php"><i class="fa-solid fa-arrow-left"></i></a>
        <canvas id="chart1"></canvas>

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
    <div class="container text-center">
    <h1 class="text-center">Ingresos y Salidas</h1>
    <label>Desde: </label>
    <input type="datetime-local" id="date1" name="date1" value=<?php echo date('Y-m-d\TH:i:s'); ?> required>
    <label>Hasta: </label>
    <input type="datetime-local" id="date2" name="date2" value=<?php echo date('Y-m-d\TH:i:s'); ?> required>
    <button class="btn btn-success" type="submit">Generar</button>
    </div>
  
    <div class="container">
        <h1 class="text-center">Ingresos</h1>
        <canvas id="chart3"></canvas>
    </div>
    <div class="container">
        <h1 class="text-center">Salidas</h1>
        <canvas id="chart4"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script>
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
        var chart3 = new Chart(ctx, {
            type: 'line',
            /* valores: line, bar*/
            data: data,
            options: options
        });
    </script>
    <script>
        document.getElementById("date1").addEventListener("input", () => console.log(document.getElementById("date1").value));
        document.getElementById("date2").addEventListener("input", () => console.log(document.getElementById("date2").value));
    </script>
    <script>
        $('.postName').select2({
            placeholder: 'Select an item',
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
    <script>
        var ctx = document.getElementById("chart3");
        var data = {
            labels: [
                <?php foreach ($data3 as $d) : ?> "<?php echo $d->DIA ?>",
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Ingresos ultimos 7 dias:',
                data: [
                    <?php foreach ($data3 as $d) : ?>
                        <?php echo $d->REGISTROS; ?>,
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
        var chart2 = new Chart(ctx, {
            type: 'line',
            /* valores: line, bar*/
            data: data,
            options: options
        });
    </script>
    <script>
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
            type: 'bar',
            /* valores: line, bar*/
            data: data,
            options: options
        });
    </script>
    <script>
        var ctx = document.getElementById("chart4");
        var data = {
            labels: [
                <?php foreach ($data4 as $d) : ?> "<?php echo $d->DIA ?>",
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Salidas en los ultimos 7 dias',
                data: [
                    <?php foreach ($data4 as $d) : ?>
                        <?php echo $d->REGISTROS; ?>,
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
        var chart4 = new Chart(ctx, {
            type: 'line',
            /* valores: line, bar*/
            data: data,
            options: options
        });
    </script>
</body>

</html>