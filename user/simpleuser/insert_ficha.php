<?php include 'settings.php'; //include settings 
?>
<!DOCTYPE html>
<html lang="es">

<?php include('header.php') ?>

<body>
    <?php
    if (!empty($_POST)) {
        $search = mysqli_real_escape_string($conn, $_POST["patente"]);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = " INSERT INTO ficha(inicio,patente)  VALUES(now(),'$search')";

        if (mysqli_query($conn, $sql)) {
            echo "Registro ingresado correctamente";
        } else {
            echo "Error: " . $sql . "" . mysqli_error($conn);
        }
        $conn->close();
    }


   

    ?>

</body>
<?php include('footer.php'); ?>


</html>