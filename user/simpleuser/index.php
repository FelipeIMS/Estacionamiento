<?php include 'settings.php'; //include settings 
$query = "SELECT ficha.id_ficha as id, diferencia, cliente.nombre_cliente, cliente.apellido_cliente, area.nombre_area, inicio, termino, vehiculo.patente from ficha
inner join vehiculo on vehiculo.patente = ficha.patente
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area
order by id ASC;";
$result = mysqli_query($conn, $query);




?>
<!DOCTYPE html>
<html lang="en">
<title>Inicio</title>
<link rel="stylesheet" href="./css/datatable.css">
<?php include('header.php') ?>

<body>
    <!-- <?php
    $accion = isset($_POST['accion']) ? $_POST['accion'] : "";
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $fin = isset($_POST['termino']) ? $_POST['termino'] : "";

    // switch ($accion) {
    //     case ("Finalizar"):
    //         if ($fin == null) {
    //             $sql = "UPDATE ficha set termino= now(), user_ficha_out = '{$_SESSION['id']}' where id_ficha = '$id'";
    //             $sql2 = "UPDATE cliente c
    //             JOIN vehiculo v ON c.id_cliente= v.cliente
    //             JOIN ficha f ON  v.patente = f.patente
    //             SET c.estado= 'Activo'
    //             WHERE f.id_ficha= '$id';";
    //             mysqli_query($conn, $sql2);
    //             $resultado = $conn->query($sql);
    //             if ($resultado) {
    //                 echo "<script>  Swal.fire({
    //                     position: 'center',
    //                     icon: 'success',
    //                     title: 'Salida registrada',
    //                     text:'Salida registrada correctamente',
    //                     showConfirmButton: false,
    //                     timer: 3000
    //                   });</script>";
    //                 echo '<script type="text/JavaScript"> setTimeout(function(){
    //                     window.location="index.php";
    //                  }, 2000); </script>';
    //             }
    //         } else {
    //             echo "<script>  Swal.fire({
    //                 position: 'center',
    //                 icon: 'warning',
    //                 title: 'Error al registrar salida',
    //                 text: 'Salida registrada anteriormente',
    //                 showConfirmButton: false,
    //                 timer: 3000
    //               });</script>";
    //             echo '<script type="text/JavaScript"> setTimeout(function(){
    //                window.location="index.php";
    //             }, 2000); </script>';
    //         }
    //         break;
    //     case ("Eliminar"):
    //         $sql = "DELETE from ficha WHERE id_ficha = '$id'";
    //         $resultado = $conn->query($sql);
    //         if ($resultado) {
    //             echo "<script>  Swal.fire({
    //                 position: 'center',
    //                 icon: 'success',
    //                 title: 'INCIDENCIA ELIMINADA',
    //                 text:'INCIDENCIA ELIMINADA EXITOSAMENTE',
    //                 showConfirmButton: false,
    //                 timer: 3000
    //             });</script>";
    //             echo '<script type="text/JavaScript"> setTimeout(function(){
    //                 window.location="index.php";
    //             }, 2000); </script>';
    //         }
    //         break;
    // }

    // ?> -->


    <div class="container">
        <button class="btn btn-primary mt-5 mb-5" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <i class="fa-solid fa-bars"></i> Menu
        </button>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel"><a href="index.php"><img
                            src="./img/logo-clinica-lircay.png" alt=""></a>
                </h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div>
                    Gestion de estacionamientos
                </div>
                <div class="dropdown mt-3">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php"><i
                                    class="fa-solid fa-house-user"></i> Inicio</a>
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
                            <a class="nav-link" href="config.php"> <i class="fa-solid fa-gear"></i> Configuracion </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i> <?php echo $_SESSION['name']; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../../includes/logout.php"><i
                                            class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a></li>
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
                    <th>Apellido</th>
                    <th>Area</th>
                    <th>Patente</th>
                    <th>Ingreso</th>
                    <th>Salida</th>
                    <th width=15%">Tiempo estacionado</th>
                    <th width="0">Finalizar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                <tr>
                    <td><?php echo $row["nombre_cliente"]; ?></td>
                    <td><?php echo $row["apellido_cliente"]; ?></td>
                    <td><?php echo $row["nombre_area"]; ?></td>
                    <td><?php echo $row["patente"]; ?></td>
                    <td><?php echo $row["inicio"]; ?></td>
                    <td><?php echo $row["termino"]; ?></td>
                    <td><?php echo $row["diferencia"]; ?></td>


                    <td>
                        <button type="button" class="btn btn-danger view_data" data-bs-backdrop="static"
                            data-bs-keyboard="false" id="<?php echo $row["id"]; ?>">Marcar salida</button>
                    </td>
                </tr>
                <?php
                    }
            ?>

                </tr>
            </tbody>
        </table>


    </div>

    <div class="modal fade" id="dataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" id="dataModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detalle de ficha</h4>
                </div>
                <div class="modal-body" id="employee_detail">
                <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <?php
                    }
            ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancelar" id="<?php echo $row["id"]; ?>" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>






    <?php include('footer.php'); ?>
    <script src="./js/datatable.js"></script>
    <script src="./js/sistema.js"></script>
    <script>
    $(document).ready(function() {
        $(document).on('click', '.view_data', function() {
            //$('#dataModal').modal();
            var employee_id = $(this).attr("id");
            $.ajax({
                url: "select.php",
                method: "POST",
                data: {
                    employee_id: employee_id
                },
                success: function(data) {
                    $('#employee_detail').html(data);
                    $('#dataModal').modal('show');
                }
            });
        });
    });

    </script>

</body>

</html>