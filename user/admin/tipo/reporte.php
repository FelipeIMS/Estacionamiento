<head>
    <meta charset="UTF-8">
</head>

<?php
if (isset($_POST['enviar'])) {

    header("Content-Type: application/vnd.ms-excel");
    $timestamp = time();
    $filename = 'Maestro_Marcas' . date("d-m-Y", $timestamp) . '.xls';
    header("Content-Disposition: attachment; filename=\"$filename\"");

?>

    <table>
        <tr>
            <th>ID</th>
            <th>Marca</th>
            <th>Estado</th>

        </tr>
        <?php
        $mysqli = include_once "conexion.php";
        $sql = "SELECT   * FROM marca_vehiculo";
        $ejecutar = mysqli_query($mysqli, $sql);
        while ($fila = mysqli_fetch_array($ejecutar)) {
        ?>
            <tr>
                <td><?php echo $fila[0] ?></td>
                <td><?php echo $fila[1] ?></td>
                <td><?php echo $fila[2] ?></td>
    <?php }
    }
 
    ?>

    </table>