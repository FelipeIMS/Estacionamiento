<head>
    <meta charset="UTF-8">
</head>

<?php
if (isset($_POST['enviar'])) {

    header("Content-Type: application/vnd.ms-excel");
    $timestamp = time();
    $filename = 'Maestro_Vehiculos' . date("d-m-Y", $timestamp) . '.xls';
    header("Content-Disposition: attachment; filename=\"$filename\"");

?>

    <table>
        <tr>
            <th>ID</th>
            <th>Patente</th>
            <th>Tipo</th>
            <th>Marca</th>
            <th>Cliente</th>
            <th>Estado</th>
     
        </tr>
        <?php
        include '../settings.php';
        $sql = "SELECT vehiculo.id_vehiculo as id,vehiculo.patente as patente,tipo_vehiculo.nombre_tpv as tipo, CONCAT(cliente.nombre_cliente,' ',cliente.apellido_cliente) as cliente,marca_vehiculo.nombre_marca as marca, vehiculo.estado_v as estado FROM vehiculo
        INNER JOIN marca_vehiculo ON marca_vehiculo.id_mv= vehiculo.marca_vehiculo
        INNER JOIN tipo_vehiculo ON tipo_vehiculo.id_tpv = vehiculo.tipo_vehiculo
        INNER JOIN cliente ON  vehiculo.cliente = cliente.id_cliente
        ORDER BY id asc";
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
    <?php }
    }

    ?>

    </table>