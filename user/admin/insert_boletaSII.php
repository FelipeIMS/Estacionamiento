<?php include('conexion.php')?>

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

    if(isset($_POST['guardar'])){

        $select_boleta =  $conn->query("SELECT  * FROM ficha WHERE boleta_sii = '".$nro_boleta."'");

        if(mysqli_num_rows($select_boleta)>0){
            echo "<script>  Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error',
                text: 'Numero de boleta ya existe',
                showConfirmButton: false,
                timer: 1000
              });</script>";
                echo '<script type="text/JavaScript"> setTimeout(function(){
               window.location="index.php";
            }, 1000); </script>';
            header("refresh: 1; url=listar.php");
        }else{

            $numero_boleta = $conn->prepare("UPDATE ficha set boleta_sii = ? where id_ficha = ?;");
            $numero_boleta->bind_param("ii", $nro_boleta, $id_ficha);
            $numero_boleta->execute();
            echo "<script>  Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Ingreso realizado correctamente',
                showConfirmButton: false,
                timer: 1000
              });</script>";
                echo '<script type="text/JavaScript"> setTimeout(function(){
               window.location="index.php";
            }, 1000); </script>';
        }
    }

    
    
    
    
    
    
    
    
    
    
    
    
    ?>
    
</body>
</html>