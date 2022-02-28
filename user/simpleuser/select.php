<?php
include('settings.php');

if(isset($_POST["employee_id"]))
{
    $output = '';
    $query1 = "SELECT id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado from ficha
    inner join vehiculo on vehiculo.patente = ficha.patente
    inner join cliente on cliente.id_cliente = vehiculo.cliente
    inner join area on area.id_area = cliente.area
    inner join convenios on cliente.convenio = convenios.id_convenio
    WHERE id_ficha ='".$_POST["employee_id"]."'";

    
    
    $result1 = mysqli_query($conn, $query1);
    $output .= '  
        <div class="table-responsive">  
            <table class="table table-bordered">';
        while($row = mysqli_fetch_array($result1))
                
                
                $output .= '
                <div class="">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Patente</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="'.$row['patente'].'" disabled readonly">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Ingreso</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="'.$row['inicio'].'" disabled readonly">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Salida</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="'.$row['termino'].'" disabled readonly">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Tiempo estacionado</span>
                        <input type="text" class="form-control" aria-label="Sizing example input"value="'.$row['diferencia'].'" disabled readonly">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Total a pagar:</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="'.$row['total'].'" disabled readonly">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Estado:</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="'.$row['estado'].'" disabled readonly">
                    </div>

                    <form method="post">
                        <a href="pagar.php?id='.$row["id_ficha"].'" class="btn btn-success">Pagar</a>
                        <input type="text" name="id" value="'.$row["id_ficha"].'" hidden>
                    </form>
                    
                </div>
                        ';
                        
                echo $output;



            }
           

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar</title>
</head>
<body>
    
</body>
</html>