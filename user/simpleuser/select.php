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
        while($row = mysqli_fetch_array($result1)){
            if($row['termino']==""){
                $sql2 = " UPDATE ficha set  user_ficha_out = '{$_SESSION['id']}' where id_ficha='".$_POST["employee_id"]."'";
                $result2 = mysqli_query($conn, $sql2);
                
                $sql4="UPDATE cliente c
                JOIN vehiculo v  ON c.id_cliente = v.cliente
                SET c.estado= 'Activo'
                WHERE v.patente='".$row['patente']."'";
                mysqli_query($conn,$sql4);
                
                $query3 = "UPDATE ficha SET termino = now() where id_ficha='".$_POST["employee_id"]."'";
                $result3 = mysqli_query($conn, $query3);
                $query7 = "SELECT termino from ficha where id_ficha ='".$_POST["employee_id"]."' ;";
                $result7 = mysqli_query($conn, $query7);
                $termino = mysqli_fetch_array($result7);


                $sql5 = "SELECT timestampdiff(MINUTE,inicio,termino) from ficha where id_ficha='".$_POST["employee_id"]."';";
                $result5 = mysqli_query($conn, $sql5);
                $diferencia = mysqli_fetch_array($result5);
                $query6 = "UPDATE ficha SET diferencia = $diferencia[0] where id_ficha='".$_POST["employee_id"]."'";

                $result6 = mysqli_query($conn, $query6); 
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
                        <input type="text" class="form-control" aria-label="Sizing example input" value="'.$termino[0].'" disabled readonly">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Tiempo estacionado</span>
                        <input type="text" class="form-control" aria-label="Sizing example input"value="'.$diferencia[0].'" disabled readonly">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Total a pagar:</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="'.$row['total'].'" disabled readonly">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Estado:</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="'.$row['estado'].'" disabled readonly">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Desc. Convenio: </span>
                        <input type="text" class="form-control" aria-label="Sizing example input>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <button type="button" onClick="asignar()" class="btn btn-info">Calcular</button>
                    </div>
                    
                    <form method="post">
                        <a href="pagar.php?id='.$row["id_ficha"].'" class="btn btn-success">Pagar</a>
                        <input type="text" name="id" value="'.$row["id_ficha"].'" hidden>
                    </form>
                    
                </div>
                        ';
                        
                echo $output;



            }else{

                $output .= '
                <div class="input-group mb-3">
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
                        <input type="text" class="form-control" id="diferencia" aria-label="Sizing example input"value="'.$row['diferencia'].'" disabled readonly">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Total a pagar:</span>
                        <input type="text" class="form-control" id="total" aria-label="Sizing example input" value="'.$row['total'].'" disabled readonly">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Estado:</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="'.$row['estado'].'" disabled readonly">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Desc. Convenio: </span>
                        <input type="text" class="form-control" id="convenio"  aria-label="Sizing example input>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <button type="button" onClick="asignar()" class="btn btn-info">Calcular</button>
                    </div>


                    <form action="pagar.php" method="POST" >
                        <a href="pagar.php?id='.$row["id_ficha"].'" id= "send" class="btn btn-success" onClick="wea();">Pagar</a>
                    </form>
                    
                </div>

                <script>
                function wea() {
                    var total = $("#total").val();
                    localStorage.setItem("total",total);
                    alert(total);
                }
                </script>
                        ';
                        
                echo $output;
            }
                



            }
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
    <script>
        function asignar() {
  var cantidad = $("#convenio").val();
  var diferencia = $("#diferencia").val();
  var total = $("#total").val();
  var dift = diferencia - cantidad;
  total = dift*20;
  $("#total").val(total);
}


    </script>
  
</body>
</html>