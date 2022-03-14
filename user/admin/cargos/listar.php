<?php
include_once "encabezado.php";
include '../settings.php';
$resultado = $conn->query("SELECT * FROM cargo");
$cargos = $resultado->fetch_all(MYSQLI_ASSOC);
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
            <h1 class="text-center">Listado de Cargos</h1>
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
                    <th>Cargo</th>
                    <th>Estado</th>


                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($cargos as $cargo) { ?>
                    <tr>
                        <td>

                            <?php if ($cargo["estado_c"] == "Activo") { ?>
                                <a class="btn btn-danger" href="eliminar.php?id=<?php echo $cargo["id_cargo"] ?>"><i class="fa-solid fa-circle-xmark"></i></i></a>

                            <?php } ?>
                            <?php if ($cargo["estado_c"] == "Inactivo") { ?>
                                <a class="btn btn-success" href="activar.php?id=<?php echo $cargo["id_cargo"] ?>"><i class="fa-solid fa-check"></i></a>

                            <?php } ?>

                            <a class="btn btn-warning" href="editar.php?id=<?php echo $cargo["id_cargo"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>

                        </td>
                        <td><?php echo $cargo["id_cargo"] ?></td>
                        <td><?php echo $cargo["nombre_cargo"] ?></td>
                        <td><?php echo $cargo["estado_c"] ?></td>


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