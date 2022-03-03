<?php include('header.php') ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ingreso manual</title>
</head>

<body>
    <div class="container mt-5 ">
        <div class="card text-center">
            <div class="card-header">
                Ingreso manual
            </div>
            <div class="card-body">
                <form action="insert_manual.php" method="POST">
                    <div class="form-group">
                        <label>Busqueda de Clientes</label>
                        <input class="mt-3 w-25" placeholder="Buscar..." class="form-control" id="search" type="text"
                            name="patente" />

                    </div>
                    <div class="form-group">
                        <label for="nombre">ENTRADA: </label>
                        <input class="text-center mt-3 w-25" value="" placeholder="Entrada" class="form-control"
                            type="datetime-local" step="1" name="entrada" id="entrada">
                    </div>
                    <div class="form-group">
                        <label for="nombre">SALIDA: </label>
                        <input class="text-center mt-3 w-25" value="" placeholder="Salida" class="form-control"
                            type="datetime-local" step="1" name="termino" id="termino">
                    </div>
                    <div class="form-outline mb-3 " style="margin: 0 auto; width: 400px;">
                        <label class="form-label mt-3" for="obs">Observacion</label>
                        <textarea required class="form-control" id="obs" name="obs" style="resize: none;"
                            rows="7"></textarea>
                    </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            <div class="form-group text-center">
                <button type="submit" class="btn btn-success">Ingresar</button>
                <a href="index.php" class="btn btn-primary">Volver</a>
            </div>
        </div>
        </form>
        <div class="form-floating mt-4">
            <textarea disabled readonly class="form-control" placeholder="Leave a comment here" rows="8" id="floatingTextarea2"
                style="height: 140px">° Ingrese manualmente fecha de ingreso y salida.
° No olvide detallar en el campo observacion.
            
            </textarea>
            <label for="floatingTextarea2">Instrucciones</label>
        </div>
    </div>
    </div>







    <?php include('footer.php') ?>
    <script>
    $(document).ready(function() {
        $("#search").autocomplete({
            source: 'search.php',
            cache: false,
            minLength: 1,
        });
    });
    </script>
</body>

</html>