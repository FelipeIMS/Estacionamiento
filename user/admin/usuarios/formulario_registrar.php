<?php include_once "encabezado.php";
include '../settings.php';
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Registrar Usuarios</h1>
            <form action="registrar.php" method="POST">
                <div class="form-group mb-3">
                    <label for="nombre">Username</label>
                    <input placeholder="" class="form-control" type="text" name="name" id="name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="nombre">Login Email</label>
                    <input placeholder="" class="form-control" type="email" name="login" id="login" required>
                </div>
                <div class="form-group mb-3">
                    <label for="nombre"> Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="Default select example">Rol</label>
                    <select class="form-select mb-3" aria-label="Default select example" id="role" name="role">
                        <option value=1>Administrador</option>
                        <option value=0>Usuario</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Default select example">Status</label>
                    <select class="form-select mb-3" aria-label="Default select example" id="status" name="status">
                        <option value=1>Activo</option>
                        <option value=0>Inactivo</option>
                    </select>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="voucher" name="voucher">
                    <label class="form-check-label" for="voucher ">
                        Permiso Voucher
                    </label>
                </div>
                <br>
                <div class="form-group">
                    <button class="btn btn-success">Guardar</button>
                    <a href="listar.php" class="btn btn-warning" style="float: right;">Volver</a>
                </div>


            </form>
        </div>
    </div>
</div>



<?php include_once "pie.php"; ?>