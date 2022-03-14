<?php include_once "encabezado.php";
include '../settings.php'; 

$resultado = $conn->query("SELECT precio from precio where estado_precio = 'Activo';");
$precio = mysqli_fetch_array($resultado);
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Cambiar precio</h1>
            <form action="cambiar.php" method="POST">
                <div class="form-group mb-3">
                    <label for="customRange1" class="form-label">Escoja precio</label>
                    <input type="range" class="form-range" id="customRange1"  min="0" max="1000" oninput="updateTextInput(this.value);">
                    <input class="form-control" value="<?php echo $precio[0]?>" type="text" id="textInput" name="precio">
                </div>


                <div class="form-group">
                    <button class="btn btn-success">Guardar</button>
                    <a href="../index/index.php" class="btn btn-warning" style="float: right;">Volver</a>
                </div>


            </form>
        </div>
    </div>
</div>
<script>
    function updateTextInput(val) {
          document.getElementById('textInput').value=val; 
        }
</script>


<?php include_once "pie.php"; ?>