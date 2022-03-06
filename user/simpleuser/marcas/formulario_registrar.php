<?php include_once "encabezado.php";
$mysqli = include_once "conexion.php";
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Registrar Convenio</h1>
            <form action="registrar.php" method="POST">
                <div class="form-group mb-3">
                    <label for="nombre">Nombre convenio</label>
                    <input placeholder="" class="form-control" type="text" name="nombreconvenio" id="nombreconvenio" required>
                </div>
                <div class="form-group mb-3">
                    <label for="nombre"> % Descuento </label>
                    <input placeholder="" class="form-control" type="number" name="descuento" id="descuento" required>
                </div>
    

                <div class="form-group">
                    <button class="btn btn-success">Guardar</button>
                    <a href="listar.php" class="btn btn-warning" style="float: right;">Volver</a>
                </div>


            </form>
        </div>
    </div>
</div>



<?php include_once "pie.php"; ?>