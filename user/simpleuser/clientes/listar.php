<?php
include_once "encabezado.php";
$mysqli = include_once "conexion.php";
$resultado = $mysqli->query("SELECT * FROM cliente
INNER JOIN area on area.id_area = cliente.area
INNER JOIN convenios on convenios.id_convenio=cliente.convenio
INNER JOIN cargo ON cargo.id_cargo=cliente.cargo
ORDER BY id_cliente");
$clientes = $resultado->fetch_all(MYSQLI_ASSOC);
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
            width: 200px;
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
            <h1 class="text-center">Listado de Clientes</h1>
        </div>
        <div id="wrapper" class="col-12">
            <a class="btn btn-success my-2" href="formulario_registrar.php"><i class="fa-solid fa-plus"></i></a>
            <a class="btn btn-warning my-2" style="float:right" href="../index.php"><i class="fa-solid fa-arrow-left"></i></a>
            <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Buscar....">

            <table id="tabla" class="table">
                <thead>
                    <tr class="header">
                        <th>Acciones</th>
                        <th>#</th>
                        <th>RUT</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Area</th>
                        <th>Estado</th>
                        <th>Convenio</th>
                        <th>Cargo</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($clientes as $cliente) { ?>
                        <tr>
                            <td>
                             
                                <a class="btn btn-warning" href="editar.php?id=<?php echo $cliente["id_cliente"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>

                            </td>

                            <td><?php echo $cliente["id_cliente"] ?></td>
                            <td><?php echo $cliente["rut"] ?></td>
                            <td><?php echo $cliente["nombre_cliente"] ?></td>
                            <td><?php echo $cliente["apellido_cliente"] ?></td>
                            <td><?php echo $cliente["nombre_area"] ?></td>
                            <td><?php echo $cliente["estado"] ?></td>
                            <td><?php echo $cliente["nombre_convenio"] ?></td>
                            <td><?php echo $cliente["nombre_cargo"] ?></td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once "pie.php" ?>
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