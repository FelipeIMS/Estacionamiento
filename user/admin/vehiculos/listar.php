<?php
include_once "encabezado.php";
include '../settings.php';
$resultado = $conn->query("SELECT CONCAT(cliente.nombre_cliente,' ',cliente.apellido_cliente) as nombres,vehiculo.id_vehiculo,vehiculo.patente,tipo_vehiculo.nombre_tpv,marca_vehiculo.nombre_marca,vehiculo.estado_v FROM vehiculo
INNER JOIN marca_vehiculo ON marca_vehiculo.id_mv=vehiculo.marca_vehiculo
INNER JOIN tipo_vehiculo ON tipo_vehiculo.id_tpv = vehiculo.tipo_vehiculo
INNER JOIN cliente ON  cliente.id_cliente=vehiculo.cliente
ORDER BY id_vehiculo ASC");


$vehiculos = $resultado->fetch_all(MYSQLI_ASSOC);
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
            <h1 class="text-center">Listado de Vehiculos</h1>
            <a class="btn btn-success my-2" href="formulario_registrar.php"><i class="fa-solid fa-plus"></i></a>
            <a class="btn btn-warning my-2" style="float:right" href="../index/index.php"><i class="fa-solid fa-arrow-left"></i></a>
            <form action="reporte.php" method="post">
                <button type="submit" class="btn btn-success" name="enviar"><i class="fa-solid fa-file-excel"></i></button>
            </form>
            <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Buscar....">



        </div>
        <table id="tabla" class="table table-hover">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>ID</th>
                    <th>Patente</th>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($vehiculos as $vehiculo) { ?>
                    <tr>

                        <td>

                            <?php if ($vehiculo["estado_v"] == "Activo") { ?>
                                <a class="btn btn-danger" href="eliminar.php?id=<?php echo $vehiculo["id_vehiculo"] ?>"><i class="fa-solid fa-circle-xmark"></i></i></a>

                            <?php } ?>
                            <?php if ($vehiculo["estado_v"] == "Inactivo") { ?>
                                <a class="btn btn-success" href="activar.php?id=<?php echo $vehiculo["id_vehiculo"] ?>"><i class="fa-solid fa-check"></i></a>

                            <?php } ?>


                            <a class="btn btn-warning" href="editar.php?id=<?php echo $vehiculo["id_vehiculo"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>



                        </td>

                        <td><?php echo $vehiculo["id_vehiculo"] ?></td>
                        <td><?php echo $vehiculo["patente"] ?></td>
                        <td><?php echo $vehiculo["nombre_tpv"] ?></td>
                        <td><?php echo $vehiculo["nombre_marca"] ?></td>
                        <td><?php echo $vehiculo["nombres"] ?></td>
                        <td><?php echo $vehiculo["estado_v"] ?></td>


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