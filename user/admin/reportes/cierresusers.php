<head>
    <meta charset="UTF-8">
    <script src="./js/sweatAlert.js"></script>
</head>

<?php
include '../settings.php';


$date1 = $_POST['datenew'];
$date2 = $_POST['datenew2'];
$nombre = $_POST['postName'];

$existe = mysqli_query($conn, "SELECT DAY(fecha_pago) DIA,SUM(total) total_dia,users.name as user_venta FROM ficha
INNER JOIN users ON users.id = ficha.user_ficha_out
WHERE WEEK(fecha_pago)= WEEK(CURDATE()) AND
fecha_pago BETWEEN '$date1' and '$date2'
AND
ficha.user_ficha_out='$nombre'
GROUP BY DIA,DAYNAME(fecha_pago)
ORDER BY fecha_pago");



if(isset($_POST['enviar'])){
        
        header("Content-Type: application/vnd.ms-excel");
        $timestamp = time();
        $filename = 'Reporte_' . date("d-m-Y",$timestamp) . '.xls';
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
            
        ?>
        <table>
        <tr>
            <th>Cajero</th>
            <th>Dia</th>
            <th>Total del dia</th>

        </tr>
        <?php

        while ($fila = mysqli_fetch_array($existe)) {
            ?>
                <tr>
                    <td><?php echo $fila[2] ?></td>
                    <td><?php echo $fila[0] ?></td>
                    <td><?php echo $fila[1] ?></td>

                </tr>

                <?php }
    } ?>


</table>
