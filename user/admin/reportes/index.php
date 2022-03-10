<?php
include '../settings.php';
date_default_timezone_set("America/Santiago");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Reporte por Mes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <?php


    $date1 = isset($_POST['date1']) ? $_POST['date1'] : "";
    $date2 = isset($_POST['date2']) ? $_POST['date2'] : "";


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
    ?>



    <div class="container">
        <h1 class="text-center">Ingresos Por Mes</h1>
        <form method="post" class="text-center">

            <label>Desde: </label>
            <input type="datetime-local"  id="date1"  name="date1" value=<?php echo date('Y-m-d\TH:i:s'); ?>  required>
            <label>Hasta: </label>
            <input type="datetime-local" id="date2"  name="date2"  value=<?php echo date('Y-m-d\TH:i:s'); ?>  required>
            <button class="btn btn-success" type="submit">Generar</button>

        </form>
        <a class="btn btn-warning my-2" style="float:right" href="../index.php"><i class="fa-solid fa-arrow-left"></i></a>
        <canvas id="chart1"></canvas>

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
        var chart1 = new Chart(ctx, {
            type: 'bar',
            /* valores: line, bar*/
            data: data,
            options: options
        });
    </script>
    <script>
        document.getElementById("date1").addEventListener("input", () => console.log(document.getElementById("date1").value));
        document.getElementById("date2").addEventListener("input", () => console.log(document.getElementById("date2").value));

    </script>
 
</body>

</html>