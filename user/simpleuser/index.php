<?php include 'settings.php'; //include settings 
$query = "SELECT ficha.id_ficha as id, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado, ficha.convenio_sn, ficha.convenio_t from ficha
inner join vehiculo on vehiculo.patente = ficha.patente
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area
inner join convenios on cliente.convenio = convenios.id_convenio
order by inicio DESC;";
$result = mysqli_query($conn, $query);


$query2 = "SELECT count(espacio_ocupado) from ficha where termino is null; ";
$result2 = mysqli_query($conn, $query2);
$espacios2= mysqli_fetch_array($result2);





?>
<!DOCTYPE html>
<html lang="en">
<title>Inicio</title>
<link rel="stylesheet" href="./css/datatable.css">
<?php include('header.php') ?>

<body>

            <div class="form-group mt-5"> 
                <input disabled class="form-control w-50 text-center position-relative top-50 start-50 translate-middle" id="contador" type="text" name="contador" value="Espacios ocupados: <?php echo $espacios2[0]; ?> de 62" /> 
            </div>
    <div class="container mt-5">
        <button class="btn btn-primary " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <i class="fa-solid fa-bars"></i> Menu
        </button>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel"><a href="index.php"><img src="./img/logo-clinica-lircay.png" alt=""></a>
                </h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div>
                    Gestion de estacionamientos
                </div>
                <div class="dropdown mt-3">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php"><i class="fa-solid fa-house-user"></i> Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registro_ficha.php"><i class="fa-solid fa-circle-plus"></i>
                                Ingresar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reporte.php"><i class="fa-solid fa-file-excel"></i> Generar
                                reporte</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"> <i class="fa-solid fa-gear"></i> Configuracion </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i> <?php echo $_SESSION['name']; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../../includes/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>



        <table class="table table-bordered" id="tabla">
            <thead>

                <tr>
                    <!-- <th>ID</th> -->
                    <th>Nombre</th>
                    <th>Patente</th>
                    <th>Ingreso</th>
                    <th>Salida</th>
                    <th>Estado</th>
                    <th>Convenio</th>
                    <th width=12%">Tiempo estacionado</th>
                    <th width=15%">Total</th>
                    <th width="0%">Voucher</th>
                    <th width="0%">Pagar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                <tr>
                    <td><?php echo $row["nombre_cliente"]; ?></td>
                    <td><?php echo $row["patente"]; ?></td>
                    <td><?php echo $row["inicio"]; ?></td>
                    <td><?php echo $row["termino"]; ?></td>
                    <td><?php echo $row["estado"]; ?></td>
                    <td><?php echo $row["convenio_sn"]; ?></td>
                    <td><?php echo $row["diferencia"]; ?></td>
                    <td><?php echo $row["total"]; ?></td>


                    <td>
                        <button type="button" class="btn btn-danger view_data" data-bs-backdrop="static" data-bs-keyboard="false" id="<?php echo $row["id"]; ?>"><i class="fa-brands fa-readme"></i></button>

                    </td>

                    <td>
                        <a class="btn btn-warning" href="bestfinalizar.php?id=<?php echo $row["id"] ?>"  <?php if ($row['estado'] == 'Pagado'){ ?> style="display: none;" <?php   } ?>><i class="fa-solid fa-cash-register"></i></a>
                    
                    </td>
                </tr>
            <?php
                    }
            ?>

            </tr>
            </tbody>
        </table>


    </div>



    <div class="modal fade" id="dataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="dataModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detalle de ficha</h4>
                </div>
                <div class="modal-body" id="employee_detail">


                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default cancelar" id="<?php echo $row["id"]; ?>" data-bs-dismiss="modal">Cerrar</button>


                </div>
            </div>
        </div>
    </div>






    <?php include('footer.php'); ?>
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
        $(document).ready(function() {
            $(document).on('click', '.cancelar', function() {
                //$('#dataModal').modal();
                var employee_id = $(this).attr("id");
                $.ajax({
                    url: "select.php",
                    method: "POST",
                    data: {
                        employee_id: employee_id
                    },
                    success: function(data) {
                        $(document).ajaxStop(function() {
                            window.location.reload();
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>