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

    $id_ficha = $_POST['id_ficha'];
    $nro_boleta = $_POST['nro_boleta'];
    $obs = $_POST['obs'];
    
    if(isset($_POST['guardar'])){
        
        $select_boleta =  $conn->query("SELECT  * FROM ficha WHERE boleta_sii = '".$nro_boleta."'");

        if(mysqli_num_rows($select_boleta)>0){
            echo '<script>toastr.error("Numero de boleta ya ingresado anteriormente")</script>';
            header("refresh: 1; url=index.php");
        }else{

            $numero_boleta = $conn->prepare("UPDATE ficha set boleta_sii = ?, observacion = ? where id_ficha = ?;");
            $numero_boleta->bind_param("isi", $nro_boleta,$obs, $id_ficha);
            $numero_boleta->execute();
            echo '<script>toastr.success("Numero de boleta ingresada correctamente")</script>';
            header("refresh: 1; url=index.php");
        }

    }

    
    
    
    
    
    
    
    
    
    
    
    
    ?>
    
</body>
</html>