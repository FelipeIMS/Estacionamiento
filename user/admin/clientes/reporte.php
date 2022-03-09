<head>
    <meta charset="UTF-8">
</head>

<?php
if (isset($_POST['enviar'])) {

    header("Content-Type: application/vnd.ms-excel");
    $timestamp = time();
    $filename = 'Maestro_Clientes' . date("d-m-Y", $timestamp) . '.xls';
    header("Content-Disposition: attachment; filename=\"$filename\"");

?>

    <table>
        <tr>
            <th>RUT</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Area</th>
            <th>Estado</th>
            <th>Convenio</th>
            <th>Descuento</th>
            <th>Cargo</th>
        </tr>
        <?php
        include '../settings.php';
        $sql = "SELECT  cliente.rut as rut,cliente.nombre_cliente as nombres, cliente.apellido_cliente as apellidos,area.nombre_area as area,cliente.estado as estado,
    convenios.nombre_convenio as convenio,convenios.tiempo as descuentoconv ,cargo.nombre_cargo as cargo FROM  cliente
    INNER JOIN  area ON area.id_area = cliente.area
    INNER JOIN cargo ON cargo.id_cargo= cliente.cargo
    INNER JOIN convenios ON convenios.id_convenio = cliente.convenio";
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
                <td><?php echo $fila[6] ?></td>
                <td><?php echo $fila[7] ?></td>
            </tr>
    <?php }
    }

    ?>

    </table>