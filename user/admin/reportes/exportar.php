<head>
    <meta charset="UTF-8">
    <script src="./js/sweatAlert.js"></script>
</head>

<?php
include '../settings.php';


$date1 = $_POST['date1'];
$date2 = $_POST['date2'];

$existe = mysqli_query($conn, "SELECT ficha.id_ficha as ticket,cliente.nombre_cliente, cliente.apellido_cliente, area.nombre_area, cargo.nombre_cargo,vehiculo.patente,  inicio, termino, diferencia,convenios.nombre_convenio,convenio_v , total,ficha.boleta_sii as boleta, ficha.fecha_pago,precio.precio as valorminuto from ficha
INNER JOIN precio ON precio.id_precio = ficha.id_minutos
inner join vehiculo on vehiculo.patente = ficha.patente
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area
inner join convenios on cliente.convenio = convenios.id_convenio
inner join cargo on cargo.id_cargo= cliente.cargo
where inicio  between '$date1' and '$date2' + INTERVAL 1 DAY
ORDER BY ficha.id_ficha ASC;");



if(isset($_POST['enviar'])){
        
        header("Content-Type: application/vnd.ms-excel");
        $timestamp = time();
        $filename = 'Reporte_' . date("d-m-Y",$timestamp) . '.xls';
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
            
        ?>
        <table>
        <tr>
            <th>Ticket</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Area</th>
            <th>Cargo</th>
            <th>Patente</th>
            <th>Inicio</th>
            <th>Termino</th>
            <th>Tiempo estacionado</th>
            <th>Convenio</th>
            <th>Desc. Convenio</th>
            <th>Total</th>
            <th>Boleta SII</th>
            <th>Fecha Pago</th>
            <TH>Valor minuto</TH>
        </tr>
        <?php

        while ($fila = mysqli_fetch_array($existe)) {
            ?>
                <tr>
                    <td><?php echo $fila[0] ?></td>
                    <td><?php echo $fila[1] ?></td>
                    <td><?php echo $fila[2] ?></td>
                    <td><?php echo $fila[3] ?></td>
                    <td><?php echo $fila[4] ?></td>
                    <td><?php echo $fila[5] ?></td>
                    <td><?php echo $fila[6] ?></td>
                    <td><?php echo $fila[7] ?></td>
                    <td><?php echo $fila[8] ?> Minutos</td>
                    <td> <?php echo $fila[9] ?></td>
                    <td>$ <?php echo $fila[10] ?></td>
                    <td>$ <?php echo $fila[11] ?></td>
                    <td><?php echo $fila[12] ?></td>
                    <td><?php echo $fila[13] ?></td>
                    <td><?php echo $fila[14] ?></td>
                </tr>

                <?php }
    } ?>


</table>
