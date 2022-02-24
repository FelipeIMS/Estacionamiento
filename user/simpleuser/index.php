<?php include 'settings.php'; //include settings 
$query = "SELECT ficha.id_ficha as id, cliente.nombre_cliente, cliente.apellido_cliente, area.nombre_area, vehiculo.patente, inicio, termino, espacio_ocupado FROM ficha
inner join vehiculo on vehiculo.id_vehiculo = ficha.vehiculo
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area
order by id;";
$query2="SELECT sum(espacio_ocupado) as contador from ficha  where termino is null;";
$result = mysqli_query($conn, $query);
$result2=mysqli_query($conn, $query2);
$total=0;
while($row = $result2->fetch_assoc()){
	$total = $total + $row['contador']; // Sumar variable $total + resultado de la consulta
}



?>
<!DOCTYPE html>
<html lang="en">
    <title>Inicio</title>
    <link rel="stylesheet" href="./css/datatable.css">
<?php include('header.php')?>

<body>
    <?php
    $accion = isset($_POST['accion'])?$_POST['accion']:"";
    $id= isset($_POST['id'])?$_POST['id']:"";
    $fin= isset($_POST['termino'])?$_POST['termino']:"";

    switch($accion){
        case("Finalizar"):
            if($fin==null){
                $sql = "UPDATE ficha set termino= now() where id_ficha = '$id'";
                $resultado = $conn -> query($sql);
                if($resultado){
                    echo "<script>  Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Salida registrada',
                        text:'Salida registrada correctamente',
                        showConfirmButton: false,
                        timer: 3000
                      });</script>";
                      echo '<script type="text/JavaScript"> setTimeout(function(){
                        window.location="index.php";
                     }, 2000); </script>';
                }
            }else{
                echo "<script>  Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Error al registrar salida',
                    text: 'Salida registrada anteriormente',
                    showConfirmButton: false,
                    timer: 3000
                  });</script>";
                  echo '<script type="text/JavaScript"> setTimeout(function(){
                   window.location="index.php";
                }, 2000); </script>';
            }
            break;
        case("Eliminar"):
            $sql = "DELETE from incidencias WHERE id_incidencias = '$id'";
            $resultado = $conn -> query($sql);
            if($resultado){
                echo "<script>  Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'INCIDENCIA ELIMINADA',
                    text:'INCIDENCIA ELIMINADA EXITOSAMENTE',
                    showConfirmButton: false,
                    timer: 3000
                });</script>";
                echo '<script type="text/JavaScript"> setTimeout(function(){
                    window.location="index.php";
                }, 2000); </script>';
            }
            break;

    }

    ?>

    <div class="container">
        <button class="btn btn-primary mt-5 mb-5" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <i class="fa-solid fa-bars"></i> Menu
        </button>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel"><a href="index.php"><img src="./img/logo-clinica-lircay.png" alt=""></a>
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
                            <a class="nav-link active" aria-current="page" href="index.php"><i class="fa-solid fa-house-user"></i> Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ingresar.php"><i class="fa-solid fa-circle-plus"></i> Ingresar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reporte.php"><i class="fa-solid fa-file-excel"></i> Generar reporte</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i> Perfil
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../../includes/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container">

            <?php
            echo '<input type="text" disabled class="input w-50 text-center position-relative top-50 start-50 translate-middle" value="Espacios ocupados: '  . htmlspecialchars($total) . ' de 50" />'."\n";
            ?>
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
                    <th>Finalizar</th>
                    <th>Acciones</th>
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

                    <td>
                        <form method="post">
                            <input type="submit" name="accion" value="Finalizar" class="btn btn-danger">
                            <input type="text" name="id" value="<?php echo $row["id"]; ?>" hidden>
                            <input type="text" name="termino" value="<?php echo $row["termino"]; ?>" hidden>
                        </form>
                    </td>

                    <td>
                        <form method="post">
                            <input type="text" name="id" value="<?php echo $row["id"]; ?>" hidden>
                            <input type="submit" name="accion" value="Eliminar" class='btn btn-warning'></input>
                        </form>
                    </td>
                </tr>
                <?php
                }
                ?>

                </tr>
            </tbody>
        </table>


    </div>





    <?php include('footer.php');?>
    <script src="./js/datatable.js"></script>
    <script src="./js/sistema.js"></script>

</body>

</html>