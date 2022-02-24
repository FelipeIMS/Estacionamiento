<head>
<meta charset="UTF-8">
<script src="./js/sweatAlert.js"></script>
</head>

<?php


$date1 = $_POST['date1'];
$date2 = $_POST['date2'];

if(isset($_POST['enviar'])){

header("Content-Type: application/vnd.ms-excel");
$timestamp = time();
$filename = 'Reporte_' . date("d-m-Y",$timestamp) . '.xls';
header("Content-Disposition: attachment; filename=\"$filename\"");

?>

<table>
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Area</th>
        <th>Patente</th>
        <th>Inicio</th>
        <th>Fin</th>
    </tr>
    <?php
    include("settings.php");
    $sql = "SELECT cliente.nombre_cliente, cliente.apellido_cliente, area.nombre_area, vehiculo.patente, inicio, termino from ficha
    inner join vehiculo on vehiculo.id_vehiculo = ficha.patente
    inner join cliente on cliente.id_cliente = vehiculo.cliente
    inner join area on area.id_area = cliente.area
    where inicio and termino between '$date1' and '$date2';";
    $ejecutar = mysqli_query($conn, $sql);
    while ($fila = mysqli_fetch_array($ejecutar)) {
    ?>
        <tr>
            <td><?php echo $fila[0] ?></td>
            <td><?php echo $fila[1] ?></td>
            <td><?php echo $fila[2] ?></td>
            <td><?php echo $fila[3] ?></td>
            <td><?php echo $fila[4] ?></td>
            <td><?php echo $fila[5] ?></td>
        </tr>
    
    <?php } } ?>


</table>
