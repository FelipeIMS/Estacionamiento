<?php include 'settings.php'; //include settings 
$query = "SELECT * FROM users
order by id ASC;";
$result = mysqli_query($conn, $query);



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('header.php') ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">

</head>

<body>
    <div class="container">
        <h1 class="text-center">Registrar Usuarios</h1>
        <a class="btn btn-success" href="insert-user.php"> Registrar </a>
        <a class="btn btn-warning " href="index.php" style="float: right;"> Volver </a>

        <br>
        <table class="table table-bordered" id="tabla">
            <thead>

                <tr>
                    <!-- <th>ID</th> -->
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Login</th>
                    <th>Password</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["login"]; ?></td>
                    <td><?php echo $row["password"]; ?></td>
                    <td><?php echo $row["role"]; ?></td>
                    <td>
                        <form method="post">
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


</body>
<?php include('footer.php'); ?>



</html>