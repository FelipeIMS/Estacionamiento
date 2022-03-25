<?php

date_default_timezone_set("America/Santiago");


/* Entradas primeros 7 dias */
$sql = "SELECT DAY(inicio) DIA,COUNT(inicio) REGISTROS FROM ficha
WHERE WEEK(inicio)= WEEK(CURDATE()) AND
inicio BETWEEN date_add(NOW(), INTERVAL -6 DAY) AND NOW()
GROUP BY DIA,DAYNAME(inicio)
ORDER BY inicio";
$sql2 = "SELECT DAY(inicio) DIA,COUNT(inicio) REGISTROS FROM ficha
WHERE WEEK(inicio)= WEEK(CURDATE()) AND
inicio BETWEEN date_add(NOW(), INTERVAL -6 DAY) AND NOW()
GROUP BY DIA,DAYNAME(inicio)
ORDER BY inicio";
$viewer = mysqli_query($conn, $sql);
$viewer2 = mysqli_query($conn, $sql2);
$viewer = mysqli_fetch_all($viewer, MYSQLI_ASSOC);
$viewer2 = mysqli_fetch_all($viewer2, MYSQLI_ASSOC);
$viewer = json_encode(array_column($viewer, 'DIA'), JSON_NUMERIC_CHECK);
$viewer2 = json_encode(array_column($viewer2, 'REGISTROS'), JSON_NUMERIC_CHECK);


/* Entradas ultimos 7 dias */
$sql = "SELECT DAY(termino) DIA,COUNT(termino) REGISTROS FROM ficha
WHERE WEEK(termino)= WEEK(CURDATE()) AND
termino BETWEEN date_add(NOW(), INTERVAL -6 DAY) AND NOW()
GROUP BY DIA,DAYNAME(termino)
ORDER BY termino";
$sql2 = "SELECT DAY(termino) DIA,COUNT(termino) REGISTROS FROM ficha
WHERE WEEK(termino)= WEEK(CURDATE()) AND
termino BETWEEN date_add(NOW(), INTERVAL -6 DAY) AND NOW()
GROUP BY DIA,DAYNAME(termino)
ORDER BY termino";
$terminoid = mysqli_query($conn, $sql);
$terminoval = mysqli_query($conn, $sql2);
$terminoid = mysqli_fetch_all($terminoid, MYSQLI_ASSOC);
$terminoval = mysqli_fetch_all($terminoval, MYSQLI_ASSOC);
$terminoid = json_encode(array_column($terminoid, 'DIA'), JSON_NUMERIC_CHECK);
$terminoval = json_encode(array_column($terminoval, 'REGISTROS'), JSON_NUMERIC_CHECK);


/* Registro por dia*/

$datenew = isset($_POST['datenew']) ? $_POST['datenew'] : "";
$datenew2 = isset($_POST['datenew2']) ? $_POST['datenew2'] : "";
$conn->query("SET lc_time_names = 'es_ES'");
$sql = "SELECT DAY(fecha_pago) Mes, SUM(total) total_mes
FROM ficha
WHERE fecha_pago and fecha_pago between '$datenew' and '$datenew2'
GROUP BY Mes
ORDER BY Mes";
$sql2 = "SELECT DAY(fecha_pago) Mes, SUM(total) total_mes
FROM ficha
WHERE fecha_pago and fecha_pago between '$datenew' and '$datenew2'
GROUP BY Mes
ORDER BY Mes";

$mesid = mysqli_query($conn, $sql);
$mesval = mysqli_query($conn, $sql2);
$mesid = mysqli_fetch_all($mesid, MYSQLI_ASSOC);
$mesval = mysqli_fetch_all($mesval, MYSQLI_ASSOC);
$mesid = json_encode(array_column($mesid, 'Mes'), JSON_NUMERIC_CHECK);
$mesval = json_encode(array_column($mesval, 'total_mes'), JSON_NUMERIC_CHECK);


/* Registro ultimos 30 dias gertson*/


$sql = "SELECT DAY(fecha_pago) dia, SUM(total) total_dia,users.name as user_venta
FROM ficha
INNER JOIN users ON users.id = ficha.user_ficha_out
WHERE  ficha.fecha_pago between curdate() - interval 30 day and curdate() AND
users.id = 16
group by user_venta,DIA,DAYNAME(fecha_pago)
order by dia";
$sql2 = "SELECT DAY(fecha_pago) dia, SUM(total) total_dia,users.name as user_venta
FROM ficha
INNER JOIN users ON users.id = ficha.user_ficha_out
WHERE  ficha.fecha_pago between curdate() - interval 30 day and curdate() AND
users.id = 17
group by user_venta,DIA,DAYNAME(fecha_pago)
order by dia";



$userid = mysqli_query($conn, $sql);
$userval = mysqli_query($conn, $sql);
$username = mysqli_query($conn, $sql);
$userid = mysqli_fetch_all($userid, MYSQLI_ASSOC);
$userval = mysqli_fetch_all($userval, MYSQLI_ASSOC);
$username = mysqli_fetch_all($username, MYSQLI_ASSOC);
$userid = json_encode(array_column($userid, 'dia'), JSON_NUMERIC_CHECK);
$userval = json_encode(array_column($userval, 'total_dia'), JSON_NUMERIC_CHECK);
$username = json_encode(array_column($username, 'user_venta'), JSON_NUMERIC_CHECK);



$userid2 = mysqli_query($conn, $sql2);
$userval2 = mysqli_query($conn, $sql2);
$username2 = mysqli_query($conn, $sql2);
$userid2 = mysqli_fetch_all($userid2, MYSQLI_ASSOC);
$userval2= mysqli_fetch_all($userval2, MYSQLI_ASSOC);
$username2 = mysqli_fetch_all($username2, MYSQLI_ASSOC);
$userid2 = json_encode(array_column($userid2, 'dia'), JSON_NUMERIC_CHECK);
$userval2 = json_encode(array_column($userval2, 'total_dia'), JSON_NUMERIC_CHECK);
$username2 = json_encode(array_column($username2, 'user_venta'), JSON_NUMERIC_CHECK);

?>