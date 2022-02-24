<?php include 'settings.php'; //include settings 
?>
<!DOCTYPE html>
<html lang="es">

<?php include('header.php') ?>

<body>
    <?php
    if (!empty($_POST)) {
        $search = mysqli_real_escape_string($conn, $_POST["patente"]);
        $registro = mysqli_query($conn,"SELECT patente, termino from ficha where termino is null and patente ='$search';");
        $contador = $_POST['contador'];
        if(!$contador = 50){
            echo "<script>  Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Error al ingresar ficha',
                text: 'No hay espacio para estacionar',
                showConfirmButton: false,
                timer: 3000
              });</script>";
               echo '<script type="text/JavaScript"> setTimeout(function(){
               window.location="registro_ficha.php";
            }, 3000); </script>';

        }else{

            if(mysqli_num_rows($registro)>0){
                echo "<script>  Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Error al ingresar ficha',
                    text: 'No puede ingresar ficha si no finaliza la anterior',
                    showConfirmButton: false,
                    timer: 3000
                  });</script>";
                   echo '<script type="text/JavaScript"> setTimeout(function(){
                   window.location="registro_ficha.php";
                }, 3000); </script>';
    
            }else{
    
                $sql = " INSERT INTO ficha(inicio,patente,espacio_ocupado,user_ficha)  VALUES(now(),'$search',1,'{$_SESSION['id']}')";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>  Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Registro ingresado',
                        text: 'Ficha ingresada correctamente',
                        showConfirmButton: false,
                        timer: 3000
                      });</script>";
                      echo '<script type="text/JavaScript"> setTimeout(function(){
                       window.location="index.php";
                    }, 3000); </script>';
                }
                $conn->close(); 
            }
        }

        

    }


   

    ?>

</body>
<?php include('footer.php'); ?>


</html>