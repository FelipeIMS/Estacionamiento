<!DOCTYPE html>
<html lang="en">
<title>Generar reporte</title>
<?php include('header.php');?>

<body>
    <div class="container">
        <form action="exportar.php" method="POST">
        <div class="card text-center mt-5">
            <div class="card-header">Generar</div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Desde: </label>
                            <input type="date" name="date1" id="date1">
                            <label>Hasta: </label>
                            <input type="date" name="date2" id="date2">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <button type="submit" class="btn btn-success" name="enviar">Generar</button>
                    <a href="index.php" class="btn btn-info">Volver</a> 
                </div>
            </div>
        </form>
    </div>






    <?php include('footer.php')?>

</body>

</html>