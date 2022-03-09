<head>
    <meta charset="UTF-8">
</head>

<?php

if(isset($_POST['vehiculos_excel'])){

header("Content-Type: application/vnd.ms-excel");
$timestamp = time();
$filename = 'Reporte_' . date("d-m-Y",$timestamp) . '.xls';
header("Content-Disposition: attachment; filename=\"$filename\"");

?>

<table>
    <tr>

        <th>Patente</th>
        <th>Tipo</th>
        <th>Marca</th>
        <th>Cliente</th>
    </tr>
    <?php
    $mysqli = include_once "conexion.php";
    $resultado = $mysqli->query("SELECT CONCAT(cliente.nombre_cliente,' ',cliente.apellido_cliente) as nombres,vehiculo.id_vehiculo,vehiculo.patente,tipo_vehiculo.nombre_tpv,marca_vehiculo.nombre_marca,vehiculo.estado_v FROM vehiculo
    INNER JOIN marca_vehiculo ON marca_vehiculo.id_mv=vehiculo.marca_vehiculo
    INNER JOIN tipo_vehiculo ON tipo_vehiculo.id_tpv = vehiculo.tipo_vehiculo
    INNER JOIN cliente ON  cliente.id_cliente=vehiculo.cliente
    ORDER BY id_vehiculo ASC");
    while ($fila = mysqli_fetch_array($resultado)) {
    ?>
        <tr>
            <td><?php echo $fila[2] ?></td>
            <td><?php echo $fila[3] ?></td>
            <td><?php echo $fila[4] ?></td>
            <td><?php echo $fila[0] ?></td>
        </tr>
    
    <?php } } ?>


</table>