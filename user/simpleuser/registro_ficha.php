<?php
include('settings.php');


$query2="SELECT sum(espacio_ocupado) as contador from ficha  where termino is null;";
$result2=mysqli_query($conn, $query2);


?>
<!DOCTYPE html>
<html lang="es">

<?php include('header.php') ?>


<body>
    <div class="container">

        <form  method="POST" action="insert_ficha.php">
            <div class="form-group mt-5">
                <?php
                $total=0;
                while($row = $result2->fetch_assoc()){
                    $total = $total + $row['contador']; // Sumar variable $total + resultado de la consulta  
                ?>
                <input disabled class="form-control w-50 text-center position-relative top-50 start-50 translate-middle" id="contador" type="text" name="contador" value="Espacios ocupados: <?php ?> de 50"" />
                <?php
                }
                ?>

            </div>
            <div class="form-group">
                <label>Busqueda de Clientes</label>
                <input class="form-control" id="search" type="text" name="patente" />

            </div>
            <div class="form-group">
                <label for="horain">Hora ingreso</label>
                <input type="datetime-local" class="form-control" id="horain" placeholder="">
            </div>
            <br>
            <input type="submit" name="insert" id="insert" value="Guardar" class="btn btn-success" style="margin-top: 20px;" />
        </form>



    </div>


</body>

<?php include('footer.php'); ?>
<script>
    $(document).ready(function() {
        $("#search").autocomplete({
            source: 'search.php',
            minLength: 0,
        });
    });
</script>



</html>

