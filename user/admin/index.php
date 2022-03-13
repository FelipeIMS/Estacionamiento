<?php
$mysqli = include_once "conexion.php";
$query = "SELECT ficha.id_ficha as id, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado, ficha.convenio_sn, ficha.convenio_t, ficha.convenio_v from ficha
inner join vehiculo on vehiculo.patente = ficha.patente
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area
inner join convenios on cliente.convenio = convenios.id_convenio
order by inicio DESC;";
$result = mysqli_query($mysqli, $query);
$query2 = "SELECT count(espacio_ocupado) from ficha where termino is null; ";
$result2 = mysqli_query($mysqli, $query2);
$espacios2 = mysqli_fetch_array($result2);
$ficha_sin_sii = $mysqli->query("SELECT ficha.id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,  vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, 
convenios.nombre_convenio, 
cargo.nombre_cargo, ficha.boleta_sii from ficha
inner join vehiculo on vehiculo.patente = ficha.patente
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area
inner join convenios on cliente.convenio = convenios.id_convenio
inner join cargo on cargo.id_cargo = cliente.cargo
where ficha.boleta_sii = 0;");
$tfsii = mysqli_num_rows($ficha_sin_sii);





?>
<!DOCTYPE html>
<html lang="en">
<title>Panel administrador</title>
<link rel="stylesheet" href="./css/datatable.css">
<?php include('header.php') ?>

<body>


    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
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
                        <li>
                            <a href="./usuarios/listar.php" class="nav-link px-0 align-middle not-active">
                                <span class="ms-1 d-none d-sm-inline">
                                    Usuarios</span></a>
                        </li>
                        <li>
                            <a href="./clientes/listar.php" class="nav-link px-0 align-middle not-active">
                                <span class="ms-1 d-none d-sm-inline">
                                    Clientes</span></a>
                        </li>
                        <li>
                            <a href="./convenios/listar.php" class="nav-link px-0 align-middle not-active">
                                <span class="ms-1 d-none d-sm-inline">
                                    Convenios</span></a>
                        </li>
                        <li>
                            <a href="./vehiculos/listar.php" class="nav-link px-0 align-middle not-active">
                                <span class="ms-1 d-none d-sm-inline">
                                    Vehiculos</span></a>
                        </li>
                        <li>
                            <a href="./marcas/listar.php" class="nav-link px-0 align-middle not-active">
                                <span class="ms-1 d-none d-sm-inline">
                                    Marcas</span></a>
                        </li>
                        <li>
                            <a href="./tipo/listar.php" class="nav-link px-0 align-middle not-active">
                                <span class="ms-1 d-none d-sm-inline">
                                    Tipo Vehiculo</span></a>
                        </li>
                        <li>
                            <a href="./cargos/listar.php" class="nav-link px-0 align-middle not-active">
                                <span class="ms-1 d-none d-sm-inline">
                                    Cargos</span></a>
                        </li>
                        <li>
                            <a href="./area/listar.php" class="nav-link px-0 align-middle not-active">
                                <span class="ms-1 d-none d-sm-inline">
                                    Areas</span></a>
                        </li>

                        <li>
                            <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                    id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    Reportes
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="./reportes/index.php">Estadisticas</a></li>
                                    <li><a class="dropdown-item" href="./reporte.php">Reporte</a></li>
                                </ul>
                            </div>
                        </li>


                    </ul>
                    <hr>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png"
                                alt="hugenerd" width="30" height="30" class="rounded-circle">

                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="../../includes/logout.php"><i
                                        class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3">
                <div class="form-group mt-5">
                    <input disabled
                        class="form-control w-50 text-center position-relative top-50 start-50 translate-middle"
                        id="contador" type="text" name="contador"
                        value="Espacios ocupados: <?php echo $espacios2[0]; ?> de 62" />
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal"><i class="fa-solid fa-circle-plus"></i> Nuevo ingreso</button>
                    <?php
                    if ($_SESSION['permiso_voucher'] = 1) {
                        echo ' <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#insert_voucher"><i class="fa-solid fa-circle-plus"></i> Cargar Voucher</button>';
                    }
                    ?>
                </div>
                <table class="table table-bordered" id="tabla">
                    <thead>

                        <tr>
                            <!-- <th>ID</th> -->
                            <th width="0%">Voucher</th>
                            <th width="0%">Pagar</th>
                            <th width="0%">Entrada</th>
                            <th width="0%">Salida</th>
                            <th>Nro Boleta</th>
                            <th>Patente</th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                            <th>Descuento</th>
                            <th>Estado</th>
                            <th width=15%">Total</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger view_data" data-bs-backdrop="static"
                                    data-bs-keyboard="false" id="<?php echo $row["id"]; ?>"><i
                                        class="fa-brands fa-readme"></i></button>

                            </td>

                            <td>
                                <a class="btn btn-warning" href="bestfinalizar.php?id=<?php echo $row["id"] ?>"
                                    <?php if ($row['estado'] == 'Pagado') { ?> style="display: none;" <?php   } ?>><i
                                        class="fa-solid fa-cash-register"></i></a>

                            </td>
                            <td>
                                <a class="btn btn-info" href="imprimir.php?id=<?php echo $row["id"] ?>"><i
                                        class="fa-solid fa-print"></i></a>

                            </td>
                            <td> <a class="btn btn-info" href="salida.php?id=<?php echo $row["id"] ?>"><i
                                        class="fa-solid fa-print"></i></a>
                            </td>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["patente"]; ?></td>
                            <td><?php echo $row["inicio"]; ?></td>
                            <td><?php echo $row["termino"]; ?></td>
                            <td>$<?php echo $row["convenio_v"]; ?></td>
                            <td><?php echo $row["estado"]; ?></td>
                            <td>$<?php echo $row["total"]; ?></td>



                        </tr>
                        <?php
                            }
                    ?>

                        </tr>
                    </tbody>
                </table>






            </div>
        </div>
    </div>







    </div>



    <div class="modal fade" id="dataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" id="dataModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detalle de ficha</h4>
                </div>
                <div class="modal-body" id="employee_detail">


                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default cancelar" id="<?php echo $row["id"]; ?>"
                        data-bs-dismiss="modal">Cerrar</button>


                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="insert_voucher" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingreso Manual Voucher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ui-front">
                    <div class="container ">

                        <form method="POST" action="insert_boletaSII.php" class="">
                            <div class="form-group">
                                <label for="descripcion">Ficha: </label>
                                <select id="id_ficha" name="id_ficha" required>
                                    <?php

                                if ($tfsii >= 1) {

                                    ?>
                                    <option value="0">Escoja ficha</option>
                                    <?php
                                    while ($row = $ficha_sin_sii->fetch_object()) {
                                ?>
                                    <option value="<?php echo $row->id_ficha ?>"><?php echo $row->id_ficha ?></option>
                                    <?php
                                    }
                                }
                                ?>
                                </select>
                                <br>
                                <br>
                                <div class="form-group">
                                    <label>Nro Boleta SII</label>
                                    <input class="form-control" id="nro_boleta" type="number" name="nro_boleta"
                                        required />

                                </div>

                            </div>
                            <div class="form-floating mt-4">
                                <textarea disabled readonly class="form-control" placeholder="Leave a comment here"
                                    id="floatingTextarea2"
                                    style="height: 100px">° Seleccina patente e ingresa el numero de la boleta SII.</textarea>
                                <label for="floatingTextarea2">Instrucciones</label>
                            </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <input type="submit" name="guardar" id="guardar" value="Guardar" class="btn btn-success" />
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Volver</button>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <?php include('footer.php'); ?>
    <script>
    $(document).ready(function() {
        $("#search").autocomplete({
            source: 'search.php',
            cache: false,
            minLength: 2,
        });
    });
    </script>
    <script src="./js/datatable.js"></script>
    <script src="./js/sistema.js"></script>
    <script>
    $(document).ready(function() {
        $(document).on("click", ".view_data", function() {
            //$('#dataModal').modal();
            var employee_id = $(this).attr("id");
            $.ajax({
                url: "select.php",
                method: "POST",
                data: {
                    employee_id: employee_id
                },
                success: function(data) {
                    $("#employee_detail").html(data);
                    $("#dataModal").modal("show");

                }
            });
        });
    });
    </script>


</body>

</html>