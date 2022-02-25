<?php
include('settings.php');
?>
<!DOCTYPE html>
<html lang="es">

<?php include('header.php') ?>


<body>
    <div class="container">

        <form  method="POST" action="insert_ficha.php">
            <div class="form-group mt-5">
                <?php
                $query2 = "SELECT sum(espacio_ocupado) as contador from ficha  where termino is null;"; 
                $result2 = mysqli_query($conn,$query2);
                $row = mysqli_fetch_array($result2);?>
                
                <input disabled class="form-control w-50 text-center position-relative top-50 start-50 translate-middle" id="contador" type="text" name="contador" value="Espacios ocupados<?php $max = $row[0]; ?> : de 50"" />
                
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
            cache:false,
            minLength: 1,
        });
    });
</script>



</html>

