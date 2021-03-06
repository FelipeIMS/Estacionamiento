<?php include('header.php');

include('settings.php');


$ficha_sin_sii = $conn->query("SELECT ficha.id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,  vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, 
convenios.nombre_convenio, 
cargo.nombre_cargo, ficha.boleta_sii from ficha
inner join vehiculo on vehiculo.patente = ficha.patente
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area
inner join convenios on cliente.convenio = convenios.id_convenio
inner join cargo on cargo.id_cargo = cliente.cargo
where termino is null");
$tfsii = mysqli_num_rows($ficha_sin_sii);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ingreso manual</title>
</head>

<body>
    

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-black mt-0">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="#"
                        class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Menu</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Inicio</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="clientes/listar.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Clientes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="vehiculos/listar.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Vehiculos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="ingreso_manual.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Ingreso
                                    manual</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./listacompleta.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Todas las boletas</span>
                            </a>
                        </li>
                    </ul>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png"
                                alt="hugenerd" width="30" height="30" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1"><?php echo $_SESSION['name'] ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="../../../includes/logout.php"><i
                                        class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3">

                <div class="container mt-5 ">
                    <div class="card text-center">
                        <div class="card-header">
                            Ingreso manual
                        </div>
                        <div class="card-body">
                            <form action="insert_manual.php" method="POST">
                                <div class="form-group">
        
                                    <label for="descripcion">Nro de boleta: </label>
                                    <select id="id_ficha" name="id_ficha" required>
                                        <?php
        
                                    if ($tfsii >= 1) {
        
                                    ?>
                                        <option value="0">Escoja Nro de Boleta</option>
                                        <?php
                                        while ($row = $ficha_sin_sii->fetch_object()) {
                                        ?>
                                        <option value="<?php echo $row->id_ficha ?>"><?php echo $row->id_ficha ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                    </select>
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
                            <button type="submit" class="btn btn-success" name="guardar">Ingresar</button>
                            <a href="index.php" class="btn btn-primary">Volver</a>
                        </div>
                    </div>
                    </form>
                    <div class="form-floating mt-4">
                        <textarea disabled readonly class="form-control" placeholder="Leave a comment here" rows="8"
                            id="floatingTextarea2" style="height: 140px">?? Ingrese manualmente fecha de ingreso y salida.
?? No olvide detallar en el campo observacion.
                    
                    </textarea>
                        <label for="floatingTextarea2">Instrucciones</label>
                    </div>
                </div>
            </div>
            </div>
        </div>







    <?php include('footer.php') ?>
</body>

</html>