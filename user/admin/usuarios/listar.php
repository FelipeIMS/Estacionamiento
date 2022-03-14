<?php
include_once "encabezado.php";
include '../settings.php';
$resultado = $conn->query("SELECT * FROM users");
$users = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
    <style>
        #wrapper {
            width: 100%;
        }

        table {
            width: 100%;
        }

        th,
        td {
            width: 400px;
        }

        thead>tr {
            position: relative;
            display: block;
        }

        tbody {
            display: block;
            height: 600px;
            overflow: auto;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Listado de Usuarios</h1>
            <a class="btn btn-success my-2" href="formulario_registrar.php"><i class="fa-solid fa-plus"></i></a>
            <a class="btn btn-warning my-2" style="float:right" href="../index/index.php"><i class="fa-solid fa-arrow-left"></i></a>
            <form action="reporte.php" method="post">
                <button type="submit" class="btn btn-success" name="enviar"><i class="fa-solid fa-file-excel"></i></button>
            </form>
            <br>
            <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Buscar....">

        </div>
        <table id="tabla" class="table table-hover">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Login</th>
                    <th>Rol</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($users as $user) { ?>
                    <tr>
                        <td>

                            <?php if ($user["status"] == 1) { ?>
                                <a class="btn btn-danger" href="eliminar.php?id=<?php echo $user["id"] ?>"><i class="fa-solid fa-circle-xmark"></i></i></a>

                            <?php } ?>
                            <?php if ($user["status"] == 0) { ?>
                                <a class="btn btn-success" href="activar.php?id=<?php echo $user["id"] ?>"><i class="fa-solid fa-check"></i></a>

                            <?php } ?>

                            <a class="btn btn-warning" href="editar.php?id=<?php echo $user["id"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>

                        </td>
                        <td><?php echo $user["id"] ?></td>
                        <td><?php echo $user["name"] ?></td>
                        <td><?php echo $user["login"] ?></td>
                        <td><?php echo $user["role"] ?></td>
                        <td><?php echo $user["status"] ?></td>


                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    const myFunction = () => {
        const trs = document.querySelectorAll('#tabla tr:not(.header)')
        const filter = document.querySelector('#myInput').value
        const regex = new RegExp(filter, 'i')
        const isFoundInTds = td => regex.test(td.innerHTML)
        const isFound = childrenArr => childrenArr.some(isFoundInTds)
        const setTrStyleDisplay = ({
            style,
            children
        }) => {
            style.display = isFound([
                ...children // <-- All columns
            ]) ? '' : 'none'
        }

        trs.forEach(setTrStyleDisplay)
    }
</script>
<?php include_once "pie.php" ?>