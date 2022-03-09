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
        <th>Total</th>
    </tr>
    <?php
    include("settings.php");
    $sql = "SELECT sum(total), users.name from ficha
    inner join users on users.id = ficha.user_ficha_out
    where ficha.estado = 'Pagado'
    and ficha.termino between '$date1' and '$date2'
    and ficha.user_ficha_out = '".$_SESSION["id"]."'";
    $ejecutar = mysqli_query($conn, $sql);
    while ($fila = mysqli_fetch_array($ejecutar)) {
    ?>
        <tr>
            <td><?php echo $fila[1] ?></td>
            <td><?php echo $fila[0] ?></td>
        </tr>
    
    <?php } } ?>


</table>
