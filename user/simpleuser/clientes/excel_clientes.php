<head>
    <meta charset="UTF-8">
</head>

<?php

if(isset($_POST['clientes_excel'])){

header("Content-Type: application/vnd.ms-excel");
$timestamp = time();
$filename = 'Reporte_' . date("d-m-Y",$timestamp) . '.xls';
header("Content-Disposition: attachment; filename=\"$filename\"");

?>

<table>
    <tr>

        <th>Rut</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Area</th>
        <th>Cargo</th>
        <th>Convenio</th>
    </tr>
    <?php
    $mysqli = include_once "conexion.php";
    $resultado = $mysqli->query("SELECT cliente.rut, cliente.nombre_cliente, cliente.apellido_cliente, area.nombre_area, cargo.nombre_cargo ,convenios.nombre_convenio FROM cliente
    INNER JOIN area on area.id_area = cliente.area
    INNER JOIN convenios on convenios.id_convenio=cliente.convenio
    INNER JOIN cargo ON cargo.id_cargo=cliente.cargo
    ORDER BY id_cliente;");
    while ($fila = mysqli_fetch_array($resultado)) {
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