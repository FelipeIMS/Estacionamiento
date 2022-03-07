<?php include_once "encabezado.php";
$mysqli = include_once "conexion.php";
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Registrar Area</h1>
            <form action="registrar.php" method="POST">
                <div class="form-group mb-3">
                    <label for="nombre">Area</label>
                    <input placeholder="" class="form-control" type="text" name="area" id="area">
                </div>
    

                <div class="form-group">
                    <button class="btn btn-success">Guardar</button>
                    <a href="../index.php" class="btn btn-warning" style="float: right;">Volver</a>
                </div>


            </form>
        </div>
    </div>
</div>



<?php include_once "pie.php"; ?>