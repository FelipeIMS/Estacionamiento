<?php include('settings.php');

$beneficio = $_POST['beneficio'];

if (isset($_POST['beneficio'])) {





    $traerTiempoDesc = "SELECT nombre_beneficio, tiempo_beneficio FROM beneficios WHERE id_beneficio = '$beneficio'";
    while($row = mysqli_fetch_array($traerTiempoDesc, MYSQL_ASSOC)){
        echo "<tr>"; echo "<<td>".$row['nombre_beneficio']."</td>";
        echo "<tr>"; echo "<<td>".$row['tiempo_beneficio']."</td>";
    }


}











?>