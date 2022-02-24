
<!DOCTYPE html>
<html lang="es">

<?php include('header.php') ?>


<body>
    <div class="container">

        <form  method="POST" action="insert_ficha.php">
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

