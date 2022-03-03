<?php include 'settings.php'; //include settings 
?>
<!DOCTYPE html>
<html lang="es">
    <title>Ingreso manual</title>

<?php include('header.php') ?>

<body>
    <?php

    $entrada=$_POST['entrada'];
    $termino=$_POST['termino'];
    $obs=$_POST['obs'];

    if (!empty($_POST['patente'])) {
        $search = mysqli_real_escape_string($conn, $_POST["patente"]);
        $registro2 = mysqli_query($conn, "SELECT  * FROM ficha f
        INNER JOIN  vehiculo v ON  v.patente = f.patente
        INNER JOIN  cliente c ON  c.id_cliente = v.cliente
        WHERE f.termino is null and v.patente='$search';"); 
        if (mysqli_num_rows($registro2) > 0) {
                echo "<script>  Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Error al ingresar ficha',
                    text: 'No puede ingresar ficha si no finaliza la anterior',
                    showConfirmButton: false,
                    timer: 2000
                  });</script>";
                echo '<script type="text/JavaScript"> setTimeout(function(){
                   window.location="index.php";
                }, 2000); </script>';
            } else {
                
                $sql = " INSERT INTO ficha(inicio,termino,patente,user_ficha, estado,observacion)  VALUES('$entrada','$termino','$search','{$_SESSION['id']}','No pagado','$obs')";
                $sql2="UPDATE cliente c
                JOIN vehiculo v  ON c.id_cliente = v.cliente
                SET c.estado= 'Activo'
                WHERE v.patente='$search';";
                mysqli_query($conn,$sql2);
                if (mysqli_query($conn, $sql)) {
                    echo "<script>  Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Registro ingresado',
                        text: 'Ficha ingresada correctamente',
                        showConfirmButton: false,
                        timer: 2000
                      });</script>";
                    echo '<script type="text/JavaScript"> setTimeout(function(){
                       window.location="index.php";
                    }, 2000); </script>';
                }
                $conn->close();
            }
        
    }else{
        echo "<script>  Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Error',
            text: 'Ingrese datos nuevamente',
            showConfirmButton: false,
            timer: 2000
          });</script>";
        echo '<script type="text/JavaScript"> setTimeout(function(){
           window.location="index.php";
        }, 2000); </script>';
    }




    ?>

</body>
<?php include('footer.php'); ?>


</html>