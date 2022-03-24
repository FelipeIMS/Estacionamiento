<?php

include('settings.php');


$resultado = $conn->query("SELECT * FROM cliente
INNER JOIN area on area.id_area = cliente.area
INNER JOIN convenios on convenios.id_convenio=cliente.convenio
INNER JOIN cargo ON cargo.id_cargo=cliente.cargo
ORDER BY id_cliente");
$clientes = $resultado->fetch_all(MYSQLI_ASSOC);
?>
<?php include('encabezado.php')?>
<style>

.container-fluid{
    padding-left: 0 !important;
}

</style>
<div class="container-fluid">
    <div class="row flex-nowrap" >
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-black mt-0">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Menu</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="../index.php" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="listar.php" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Clientes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../vehiculos/listar.php" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Vehiculos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                                <?php
                            if ($_SESSION["permiso_salida-manual"]==1) {
                                echo ' <a href="../ingreso_manual.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Ingreso
                                    manual</span>
                            </a>';
                            }
                            ?>
                            
                        </li>
                    <li class="nav-item">
                            <a href="../listacompleta.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Todas las boletas</span>
                            </a>
                        </li>
                </ul>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png" alt="hugenerd"
                            width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1"><?php echo $_SESSION['name'] ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="../../../includes/logout.php"><i
                                    class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col py-3">
            <div class="container">
                <style>

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
                        <!-- <form action="excel_clientes.php" method="post">
                <button type="submit" name ="clientes_excel" class="btn btn-primary"><i class="fa-solid fa-file-excel"></i></button>
            </form> -->
                        <a class="btn btn-success my-2" href="formulario_registrar.php"><i
                                class="fa-solid fa-plus"></i></a>
                        <a class="btn btn-warning my-2" style="float:right" href="../index.php"><i
                                class="fa-solid fa-arrow-left"></i></a>
                        <input type="text" class="form-control" id="myInput" onkeyup="myFunction()"
                            placeholder="Buscar....">

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

                                        <a class="btn btn-warning"
                                            href="editar.php?id=<?php echo $cliente["id_cliente"] ?>"><i
                                                class="fa-solid fa-pen-to-square"></i></a>

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
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API = Tawk_API || {},
    Tawk_LoadStart = new Date();
(function() {
    var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/622b88a5a34c2456412aa178/1ftt0ri9s';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
})();
</script>
<!--End of Tawk.to Script-->