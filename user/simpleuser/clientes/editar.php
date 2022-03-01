
<?php
include_once "encabezado.php";
$mysqli = include_once "conexion.php";
$id = $_GET["id"];
$sentencia = $mysqli->prepare("SELECT id_cliente,rut,nombre_cliente , apellido_cliente,area,estado,convenio FROM cliente WHERE id_cliente = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
# Obtenemos solo una fila, que será el CLIENTE a editar
$cliente = $resultado->fetch_assoc();
if (!$cliente) {
    exit("No hay resultados para ese ID");
}

?>
<div class="row">
    <div class="col-12">
        <h1>Actualizar Cliente</h1>
        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $cliente["id_cliente"] ?>">
            <div class="form-group">
                <label for="nombre">RUT</label>
                <input value="<?php echo $cliente["rut"] ?>" placeholder="RUT" class="form-control" type="text" name="rut" id="rut" >
            </div>
            <div class="form-group">
                <label for="descripcion">Nómbres</label>
                <textarea placeholder="Descripción" class="form-control" name="descripcion" id="descripcion" cols="30" rows="10" required><?php echo $videojuego["descripcion"] ?></textarea>
            </div>
            <div class="form-group">
                <label for="descripcion">Apelidos</label>
                <textarea placeholder="Descripción" class="form-control" name="descripcion" id="descripcion" cols="30" rows="10" required><?php echo $videojuego["descripcion"] ?></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-warning" href="listar.php">Volver</a>
            </div>
        </form>
    </div>
</div>
<?php include_once "pie.php"; ?>