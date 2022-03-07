<?php
include_once "encabezado.php";
$mysqli = include_once "conexion.php";
$resultado = $mysqli->query("SELECT * FROM convenios");
$convenios = $resultado->fetch_all(MYSQLI_ASSOC);
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
            <h1 class="text-center">Listado de Convenios</h1>
            <a class="btn btn-success my-2" href="formulario_registrar.php"><i class="fa-solid fa-plus"></i></a>
            <a class="btn btn-warning my-2" style="float:right" href="../index.php"><i class="fa-solid fa-arrow-left"></i></a>
            <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Buscar....">



        </div>
        <table id="tabla" class="table table-hover">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>ID</th>
                    <th>Nombre convenio</th>
                    <th>% Descuento </th>

                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($convenios as $convenio) { ?>
                    <tr>
                    <td>
                            <a class="btn btn-warning" href="editar.php?id=<?php echo $convenio["id_convenio"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a class="btn btn-danger" href="eliminar.php?id=<?php echo $convenio["id_convenio"] ?>"><i class="fa-solid fa-trash"></i></a>

                        </td>
                        <td><?php echo $convenio["id_convenio"] ?></td>
                        <td><?php echo $convenio["nombre_convenio"] ?></td>
                        <td><?php echo $convenio["tiempo"] ?></td>

                   
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