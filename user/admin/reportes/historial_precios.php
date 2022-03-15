<head>
    <meta charset="UTF-8">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>

<?php
include '../settings.php';




$date1 = $_POST['date7'];
$date2 = $_POST['date8'];

$existe = mysqli_query($conn, "SELECT * from precio_anteriores
where fecha_precio_anterior between '$date1' and '$date2' + INTERVAL 1 DAY;");



if(isset($_POST['enviar'])){
   
        
        header("Content-Type: application/vnd.ms-excel");
        $timestamp = time();
        $filename = 'Reporte_' . date("d-m-Y",$timestamp) . '.xls';
        header("Content-Disposition: attachment; filename=\"$filename\"");
            
        ?>
        <table>
        <tr>
            <th>Precio anterior</th>
            <th>Estado</th>
            <th>Fecha de precio (inicial)</th>
        </tr>
        <?php

        while ($fila = mysqli_fetch_array($existe)) {
            ?>
                <tr>
                    <td><?php echo $fila[1] ?></td>
                    <td><?php echo $fila[2] ?></td>
                    <td><?php echo $fila[3] ?></td>
                </tr>

                <?php }
    } ?>


</table>
