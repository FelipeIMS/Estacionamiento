<?php
include('settings.php');

$date1 = $_POST['date1'];
$date2 = $_POST['date2'];

if(isset($_POST['enviar'])){

    //NOMBRE DE ARCHIVO Y CHARSET
    header('Content-Type:text/csv; charset=latin1');
	header('Content-Disposition: attachment; filename="Reporte de ingresos y salidas.csv"');

    // SALIDA DE ARCHIVO

    $salida=fopen('php://output', 'w');

    // COLUMNAS DE ARCHIVOS (ENCABEZADOS)

    fputcsv($salida, array('Nombre', 'Apellido', 'Area', 'Patente', 'Ingreso', 'Salida'));

    // QUERY CREAR REPORTE

    $reporteCsv=$conn->query("SELECT cliente.nombre_cliente, cliente.apellido_cliente, area.nombre_area, vehiculo.patente, inicio, termino from ficha
    inner join vehiculo on vehiculo.id_vehiculo = ficha.vehiculo
    inner join cliente on cliente.id_cliente = vehiculo.cliente
    inner join area on area.id_area = cliente.area
    WHERE inicio AND termino BETWEEN '$date1' and '$date2'
    ORDER BY inicio asc;");
    while($filaR=$reporteCsv->fetch_assoc()){
        fputcsv($salida, array($filaR['nombre_cliente'], 
                            $filaR['apellido_cliente'], 
                            $filaR['nombre_area'], 
                            $filaR['patente'],
                            $filaR['inicio'],
                            $filaR['termino']));

    }



}



?>