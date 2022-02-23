<?php include 'settings.php'; //include settings 
$query = "SELECT ficha.id_ficha as id, cliente.nombre_cliente, cliente.apellido_cliente, area.nombre_area, vehiculo.patente, inicio, termino, espacio_ocupado FROM ficha
inner join vehiculo on vehiculo.id_vehiculo = ficha.vehiculo
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area;";
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

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet"
        type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

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
                <h5 class="offcanvas-title" id="offcanvasExampleLabel"><img src="./img/logo-clinica-lircay.png" alt="">
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
        <!-- <ul id="slide-out" class="sidenav">
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="./img/logo-clinica-lircay.png">
                    </div>
                    <br>
                    <br>
                    <a href="#"><img class="circle" src="https://aumentada.net/wp-content/uploads/2015/05/user.png"></a>
                    <a href="#"><span class="black-text name">Usuario</span></a>
                    <a href="#"><span class="#000-text email">user@user.com</span></a>
                </div>
            </li>
            <li><a href="ingresar.php"><i class="fa-solid fa-plus"></i>Ingresar</a></li>
            <li><a href="../../includes/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Cerrar sesion</a></li>
        </ul>
        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="fa-solid fa-bars"></i></a> -->

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
                            <a href="editar.php?id=<?php echo $row["id"] ?>" class='btn btn-success'>Editar</a>
                            <input type="text" name="id" value="<?php echo $row["id"]; ?>" hidden>
                            <input type="submit" name="accion" value="Eliminar" class='btn btn-danger'></input>
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





    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="./js/sistema.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
</body>

</html>