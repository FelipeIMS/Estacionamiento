<?php include('../settings.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar</title>
</head>
<?php include('header.php') ?>

<body>
    <?php

    $termino = $_POST['termino'];
    $obs = $_POST['obs'];
    $id_ficha = $_POST['id_ficha'];
    
    if(isset($_POST['guardar'])){

            $cargarFinalizar = "UPDATE ficha set termino = '$termino', observacion = '$obs' where id_ficha = '$id_ficha'";
            mysqli_query($conn, $cargarFinalizar);
            echo '<script>toastr.success("Liberado correctamente, no olvide realizar proceso de pago.")</script>';
            header("refresh: 1; url=index.php");
        }



    
    
    
    
    
    
    
    
    
    
    
    
    ?>
    
</body>
</html>