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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet"type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                     }, 3000); </script>';
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
                }, 3000); </script>';
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
                }, 3000); </script>';
            }
            break;

    }

    ?>

    <div class="container section">
        <ul id="slide-out" class="sidenav">
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
        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="fa-solid fa-bars"></i></a>
    </div>

    <div class="container section">
        <?php
        echo '<input type="text" disabled class="input-field col s2" value="Espacios ocupados: '  . htmlspecialchars($total) . '" />'."\n";
        ?>
        
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
    <script src="./js/main.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems);
    });
    
    M.AutoInit();
    </script>
</body>

</html>