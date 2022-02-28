<?php
include('settings.php');

$query = "SELECT count(espacio_ocupado) from ficha where termino is null; ";
$result = mysqli_query($conn, $query);
$espacios= mysqli_fetch_array($result);




?>
<!DOCTYPE html>
<html lang="es">

<?php include('header.php') ?>


<body>
    <div class="container w-25">

        <form  method="POST" action="insert_ficha.php">
            <div class="form-group mt-5">
                
                <input disabled class="form-control w-50 text-center position-relative top-50 start-50 translate-middle" id="contador" type="text" name="contador" value="Espacios ocupados: <?php echo $espacios[0]; ?> de 62" />
                
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
            <a class="btn btn-warning" style="margin-top: 20px; float: right;" href="index.php">Volver</a>
        </form>



    </div>


</body>

<?php include('footer.php'); ?>
<script>
    $(document).ready(function() {
        $("#search").autocomplete({
            source: 'search.php',
            cache:false,
            minLength: 1,
        });
    });
</script>



</html>

