<?php include 'settings.php'; //include settings 
$query = "SELECT ficha.id_ficha as id, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado, ficha.convenio_sn, ficha.convenio_t, ficha.convenio_v from ficha
inner join vehiculo on vehiculo.patente = ficha.patente
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area
inner join convenios on cliente.convenio = convenios.id_convenio
where ficha.estado = 'No pagado'
order by inicio desc;";
$result = mysqli_query($conn, $query);


$query2 = "SELECT espacios, total_espacios from espacios where id = 1;";
$result2 = mysqli_query($conn, $query2);
$espacios2 = mysqli_fetch_array($result2);


$ficha_sin_sii = $conn->query("SELECT ficha.id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,  vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, 
convenios.nombre_convenio, 
cargo.nombre_cargo, ficha.boleta_sii from ficha
inner join vehiculo on vehiculo.patente = ficha.patente
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area
inner join convenios on cliente.convenio = convenios.id_convenio
inner join cargo on cargo.id_cargo = cliente.cargo
where ficha.boleta_sii is null and ficha.estado = 'Pagado';");
$tfsii = mysqli_num_rows($ficha_sin_sii);
$sql3 = "SELECT * from espacios";
$query3 = $conn->query($sql3); // Ejecutar la consulta SQL
$data3 = array(); // Array donde vamos a guardar los datos
while ($r = $query3->fetch_object()) { // Recorrer los resultados de Ejecutar la consulta SQL
    $data3[] = $r; // Guardar los resultados en la variable $data

}





$accion=(isset($_POST['accion']))?$_POST['accion']:"";

switch($accion){
    case "Actualizar":
        $espacios_o = mysqli_query($conn, "SELECT COUNT(espacio_ocupado) espacios from ficha where estado = 'No pagado';");
        $espacios_restablecer = mysqli_fetch_array($espacios_o);
        $espacios = $espacios_restablecer[0];
        $actualizar = mysqli_query($conn, "UPDATE espacios set espacios = '$espacios' where id = 1;");
        header("Refresh:0");
        break;
}





?>
<!DOCTYPE html>
<html lang="en">
<title>Inicio</title>
<link rel="stylesheet" href="./css/datatable.css">
<?php include('header.php') ?>

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
                            <a href="./clientes/listar.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Clientes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./vehiculos/listar.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Vehiculos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                        <?php
                        if ($_SESSION["permiso_salida-manual"]==1) {
                            echo ' <a href="./ingreso_manual.php" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Ingreso
                                manual</span>
                        </a>';
                        }
                        ?>
                            
                        </li>
                        <li class="nav-item">
                            <a href="listacompleta.php" class="nav-link align-middle px-0">
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
                            <li><a class="dropdown-item" href="../../includes/logout.php"><i
                                        class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3">
                <div class="form-group mb-5">
                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-8">
                                <input disabled
                                    class="form-control w-50 text-center position-relative top-50 start-50 translate-middle"
                                    id="contador" type="text" name="contador"
                                    value="Espacios ocupados: <?php echo $espacios2[0]; ?> de  <?php echo $espacios2[1]; ?>" />
                                    <form method="post" >
                                        <button type="submit" name="accion" class="btn btn-primary" value="Actualizar"><i class="fa-solid fa-arrows-rotate"></i> Actualizar contador</button>
                                    </form>
                            </div>
                            <div class="col-4 position-absolute top-0 end-0" style="width: 150px;">
                                <canvas id="chart3"></canvas>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal"><i class="fa-solid fa-circle-plus"></i> Nuevo ingreso</button>

                    <?php
                    if ($_SESSION["permiso_voucher"]==1) {
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
                            <th width="8%">Nro Boleta</th>
                            <th>Patente</th>
                            <th width=15%>Ingreso</th>
                            <th width=15%>Salida</th>
                            <th>Descuento</th>
                            <th>Estado</th>
                            <th width=10%">Total</th>

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
                                    <?php if ($row['estado'] == 'Pagado'  ) { ?> style="display: none;" <?php   } ?>><i
                                        class="fa-solid fa-cash-register"></i></a>
                                <!-- <a class="btn btn-success" href="bestfinalizar.php?id=<?php echo $row["id"] ?>"
                                    <?php if ($row['estado'] == 'Pagado' && $row['termino'] ) { ?> style="display: none;" <?php   } ?>><i
                                        class="fa-solid fa-cash-register"></i></a> -->

                            </td>
                            <td>
                                <a class="btn btn-info" href="imprimir.php?id=<?php echo $row["id"] ?>"><i
                                        class="fa-solid fa-print"></i></a>

                            </td>
                            <td> <a class="btn btn-info" href="salida.php?id=<?php echo $row["id"] ?>"
                                    <?php if ($row['termino'] == '') { ?> style="display: none;" <?php   } ?>><i
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
                <form action="exportar.php" method="POST">
                    <button type="submit" name="enviar" class="btn btn-success"><i class="fa-solid fa-money-bill"></i>
                        Cierre</button>
                </form>
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
                                <input class="form-control" id="search" type="text" name="patente" />

                            </div>
                            <div class="form-floating mt-4">
                                <textarea disabled readonly class="form-control" placeholder="Leave a comment here"
                                    id="floatingTextarea2"
                                    style="height: 100px">?? Busque por nombre o patente y luego haga click en agregar.</textarea>
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
    <!-- Modal -->
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
                                <br>
                                <br>
                                <div class="form-group">
                                    <label>Nro Boleta SII</label>
                                    <input class="form-control" id="nro_boleta" type="number" name="nro_boleta"
                                        required />
                                </div>
                                <div class="form-group mb-3">
                                    <label for="obs" class="form-label">Observacion</label>
                                    <textarea class="form-control" name="obs" id="obs" rows="6"
                                        style="resize: none;"></textarea>
                                </div>
                                <div class="form-floating mt-4">
                                    <textarea disabled readonly class="form-control" placeholder="Leave a comment here"
                                        id="floatingTextarea2"
                                        style="height: 100px">?? Seleccina Nro de boleta e ingresa el numero de la boleta SII.</textarea>
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
        <script>
        var ctx = document.getElementById("chart3");
        var data = {
            labels: ['Ocupados', 'Disponibles'],
            datasets: [{
                label: 'Espacios Estacionamiento:',
                data: [
                    <?php foreach ($data3 as $d) : ?>
                    <?php echo $d->espacios; ?>,
                    <?php echo $d->total_espacios; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };
        var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };
        var chart2 = new Chart(ctx, {
            type: 'pie',
            /* valores: line, bar*/
            data: data,
            options: options
        });
        </script>
        <script>
        var myModal = document.getElementById('exampleModal')
        var myInput = document.getElementById('search')

        myModal.addEventListener('shown.bs.modal', function() {
            myInput.focus()
        })
        </script>

        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/622b88a5a34c2456412aa178/1ftt0ri9s';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
        </script>
        <!--End of Tawk.to Script-->
</body>

</html>