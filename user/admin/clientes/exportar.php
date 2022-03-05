<head>
<meta charset="UTF-8">
<script src="./js/sweatAlert.js"></script>
</head>

<?php

header("Content-Type: application/vnd.ms-excel");
$timestamp = time();
$filename = 'Reporte_' . date("d-m-Y",$timestamp) . '.xls';
header("Content-Disposition: attachment; filename=\"$filename\"");

?>

<table>
    <tr>
        <th>ID</th>
        <th>RUT</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Estado</th>
        <th>Convenio</th>
        <th>Area</th>

    </tr>
    <?php
    include("conexion.php");
    $sql = "SELECT cliente.id_cliente as id,cliente.rut as rut,cliente.nombre_cliente as nombres,cliente.apellido_cliente as apellidos,cliente.estado as estado,convenios.nombre_convenio as convenio,area.nombre_area area FROM cliente
    INNER JOIN area on area.id_area=cliente.area
    INNER JOIN convenios on convenios.id_convenio= cliente.convenio";
    $ejecutar = mysqli_query($mysqli, $sql);
    while ($fila = mysqli_fetch_array($ejecutar)) {
    ?>
        <tr>
            <td><?php echo $fila[0] ?></td>
            <td><?php echo $fila[1] ?></td>
            <td><?php echo $fila[2] ?></td>
            <td><?php echo $fila[3] ?></td>
            <td><?php echo $fila[4] ?></td>
            <td><?php echo $fila[5] ?></td>
            <td><?php echo $fila[6] ?></td>

        </tr>
    
    <?php }  ?>


</table>
