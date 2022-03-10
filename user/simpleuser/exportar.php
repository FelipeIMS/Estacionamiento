<head>
<meta charset="UTF-8">
<script src="./js/sweatAlert.js"></script>
</head>

<?php



if(isset($_POST['enviar'])){
    

header("Content-Type: application/vnd.ms-excel");
$timestamp = time();
$filename = 'Reporte_' . date("d-m-Y",$timestamp) . '.xls';
header("Content-Disposition: attachment; filename=\"$filename\"");

?>

<table>
    <tr>
        <th>Nombre</th>
        <th>Patente</th>
        <th>Inicio</th>
        <th>Fin</th>
        <th>Total</th>
        <th>Total final</th>
    </tr>
    <?php
    include("settings.php");
    $id = $_SESSION['id'];
    $sql_exportar = "SELECT users.name, ficha.patente, ficha.inicio, ficha.termino, ficha.total, 
    (SELECT sum(ficha.total) from ficha
    inner join users on users.id = ficha.user_ficha_out
    where users.id ='$id') as totalfinal from ficha
    inner join users on users.id = ficha.user_ficha_out
    where users.id = '$id' and ficha.fecha_pago  BETWEEN CURDATE() and CURDATE() + INTERVAL 1 DAY; ";
    $ejecutar = mysqli_query($conn, $sql_exportar);
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
