<?php

include '../settings.php';
$conn->query("SET lc_time_names = 'es_ES'");
$sql = "SELECT MONTHNAME(inicio) Mes, SUM(total) total_mes
FROM ficha
GROUP BY Mes
ORDER BY Mes"; // Consulta SQL
$query = $conn->query($sql); // Ejecutar la consulta SQL
$data = array(); // Array donde vamos a guardar los datos
while ($r = $query->fetch_object()) { // Recorrer los resultados de Ejecutar la consulta SQL
    $data[] = $r; // Guardar los resultados en la variable $data
}

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
    <div class="container">
        <h1 class="text-center">Ingresos Por Mes</h1>
        <a class="btn btn-warning my-2" style="float:right" href="../index.php"><i class="fa-solid fa-arrow-left"></i></a>

        <canvas id="chart1" ></canvas>

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
                label: '$ Ingresos por Mes',
                data: [
                    <?php foreach ($data as $d) : ?>
                        <?php echo $d->total_mes; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: "#3898db",
                borderColor: "#9b59b6",
                borderWidth: 2
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
</body>

</html>