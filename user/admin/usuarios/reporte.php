<head>
    <meta charset="UTF-8">
</head>

<?php
if (isset($_POST['enviar'])) {

    header("Content-Type: application/vnd.ms-excel");
    $timestamp = time();
    $filename = 'Maestro_Cargo' . date("d-m-Y", $timestamp) . '.xls';
    header("Content-Disposition: attachment; filename=\"$filename\"");

?>

    <table>
        <tr>
            <th>ID</th>
            <th>Cargo</th>
            <th>Estado</th>

        </tr>
        <?php
        include '../settings.php';
        $sql = "SELECT   * FROM cargo";
        $ejecutar = mysqli_query($conn, $sql);
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