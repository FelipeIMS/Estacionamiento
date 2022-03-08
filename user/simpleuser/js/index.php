<?php include 'settings.php'; //include settings 
$query = "SELECT ficha.id_ficha as id, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado, ficha.convenio_sn, ficha.convenio_t, ficha.convenio_v from ficha
inner join vehiculo on vehiculo.patente = ficha.patente
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area
inner join convenios on cliente.convenio = convenios.id_convenio
order by inicio DESC;";
$result = mysqli_query($conn, $query);


$query2 = "SELECT count(espacio_ocupado) from ficha where termino is null; ";
$result2 = mysqli_query($conn, $query2);
$espacios2 = mysqli_fetch_array($result2);





?>
<!DOCTYPE html>
<html lang="en">
<title>Inicio</title>
<link rel="stylesheet" href="./css/datatable.css">
<?php include('header.php') ?>



<body id="body-pd">
 
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> <a href="index.php" class="nav_logo"> <i class='bx bxs-parking'></i> <span class="nav_logo-name"></span> </a>
                <div class="nav_list">
                    <a href="./clientes/listar.php" class="nav_link active"><i class='bx bx-user nav_icon'></i> <span class="nav_name"></span> </a>
                    <a href="./vehiculos/listar.php" class="nav_link"> <i class='bx bxs-car'></i> <span class="nav_name">Vehiculos</span> </a>
                    <a href="./reporte.php" class="nav_link"> <i class='bx bxs-report'></i> <span class="nav_name">Reportes</span> </a>

                </div>
            </div>
            <a href="../../includes/logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Salir</span>
            </a>
        </nav>
    </div>
    <!--Container Main start-->
        <div class="container-fluid">
            <div class="row flex-nowrap">

                <div class="col py-3">
                    <div class="form-group mt-5">
                        <input disabled class="form-control w-50 text-center position-relative top-50 start-50 translate-middle" id="contador" type="text" name="contador" value="Espacios ocupados: <?php echo $espacios2[0]; ?> de 62" />
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-circle-plus"></i> Nuevo ingreso</button>
                    </div>
                    <table class="table table-bordered" id="tabla">
                        <thead>

                            <tr>
                                <!-- <th>ID</th> -->
                                <th width="0%">Voucher</th>
                                <th width="0%">Pagar</th>
                                <th width="0%">Entrada</th>
                                <th width="0%">Salida</th>
                                <th>Nombre</th>
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
                                    <button type="button" class="btn btn-danger view_data" data-bs-backdrop="static" data-bs-keyboard="false" id="<?php echo $row["id"]; ?>"><i class="fa-brands fa-readme"></i></button>

                                </td>

                                <td>
                                    <a class="btn btn-warning" href="bestfinalizar.php?id=<?php echo $row["id"] ?>" <?php if ($row['estado'] == 'Pagado') { ?> style="display: none;" <?php   } ?>><i class="fa-solid fa-cash-register"></i></a>

                                </td>
                                <td>
                                    <a class="btn btn-info" href="imprimir.php?id=<?php echo $row["id"] ?>"><i class="fa-solid fa-print"></i></a>

                                </td>
                                <td> <a class="btn btn-info" href="salida.php?id=<?php echo $row["id"] ?>"><i class="fa-solid fa-print"></i></a>
                                </td>
                                <td><?php echo $row["nombre_cliente"]; ?></td>
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
<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo ingreso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ui-front">
                        <div class="container ">

                            <form method="POST" action="insert_ficha.php" class="">
                                <div class="form-group">
                                    <label>Busqueda de Clientes</label>
                                    <input class="form-control" id="search" type="text" name="patente" autofocus=TRUE />

                                </div>
                                <div class="form-floating mt-4">
                                    <textarea disabled readonly class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px">° Busque por nombre o patente y luego haga click en agregar.</textarea>
                                    <label for="floatingTextarea2">Instrucciones</label>
                                </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="insert" id="insert" value="Agregar" class="btn btn-success" />
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Volver</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</div>
    

  
    <!--Container Main end-->

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