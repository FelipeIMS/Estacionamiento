<head>
    <meta charset="UTF-8">
</head>

<?php
if (isset($_POST['enviar'])) {

    header("Content-Type: application/vnd.ms-excel");
    $timestamp = time();
    $filename = 'Maestro_Convenios' . date("d-m-Y", $timestamp) . '.xls';
    header("Content-Disposition: attachment; filename=\"$filename\"");

?>

    <table>
        <tr>
            <th>ID</th>
            <th>Convenio</th>
            <th>$ Descuento</th>

        </tr>
        <?php
        include '../settings.php';
        $sql = "SELECT  * from convenios";
        $ejecutar = mysqli_query($conn, $sql);
        while ($fila = mysqli_fetch_array($ejecutar)) {
        ?>
            <tr>
                <td><?php echo $fila[0] ?></td>
                <td><?php echo $fila[1] ?></td>
                <td><?php echo $fila[2] ?></td>

            </tr>
    <?php }
    }

    ?>

    </table>