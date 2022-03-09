<head>
    <meta charset="UTF-8">
    <script src="./js/sweatAlert.js"></script>
</head>

<?php
include("settings.php");


$date1 = $_POST['date1'];
$date2 = $_POST['date2'];
$patente = $_POST['patente'];

$existe = mysqli_query($conn, "	SELECT cliente.nombre_cliente, cliente.apellido_cliente,  vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio, cargo.nombre_cargo from ficha
inner join vehiculo on vehiculo.patente = ficha.patente
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area
inner join convenios on cliente.convenio = convenios.id_convenio
inner join cargo on cargo.id_cargo = cliente.cargo
where inicio and termino between '$date1' and '$date2'
and ficha.patente = '".$patente."';");



if(isset($_POST['enviar'])){
        
        header("Content-Type: application/vnd.ms-excel");
        $timestamp = time();
        $filename = 'Reporte_' . date("d-m-Y",$timestamp) . '.xls';
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
            
        ?>
        <table>
        <tr>
            <th>Patente</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Area</th>
            <th>Cargo</th>
            <th>Inicio</th>
            <th>Termino</th>
            <th>Diferencia</th>
            <th>Convenio</th>
            <th>Total</th>
        </tr>
        <?php

        while ($fila = mysqli_fetch_array($existe)) {
            ?>
                <tr>
                    <td><?php echo $fila[2] ?></td>
                    <td><?php echo $fila[0] ?></td>
                    <td><?php echo $fila[1] ?></td>
                    <td><?php echo $fila[3] ?></td>
                    <td><?php echo $fila[9] ?></td>
                    <td><?php echo $fila[4] ?></td>
                    <td><?php echo $fila[5] ?></td>
                    <td><?php echo $fila[6] ?></td>
                    <td><?php echo $fila[8] ?></td>
                    <td><?php echo $fila[7] ?></td>
                </tr>

                <?php }
    } ?>


</table>
