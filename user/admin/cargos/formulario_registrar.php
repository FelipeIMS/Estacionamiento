<?php include_once "encabezado.php";
include '../settings.php';
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Registrar Cargo</h1>
            <form action="registrar.php" method="POST">
                <div class="form-group mb-3">
                    <label for="nombre">Nombre Cargo</label>
                    <input placeholder="" class="form-control" type="text" name="cargo" id="cargo" required>
                </div>
                <div class="form-group">
                    <label for="Default select example">Estado</label>
                    <select class="form-select mb-3" aria-label="Default select example" id="estado_c" name="estado_c">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
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