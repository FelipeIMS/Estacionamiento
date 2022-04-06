<?php include_once "encabezado.php";
include_once "settings.php";
$resultado = $conn->query("SELECT * FROM tipo_vehiculo ");
$t = mysqli_num_rows($resultado);
$resultado2 = $conn->query("SELECT * FROM marca_vehiculo ");
$t2 = mysqli_num_rows($resultado2);

$resultado3 = $conn->query("SELECT *, concat(cliente.nombre_cliente,' ',cliente.apellido_cliente) n FROM cliente ORDER BY nombre_cliente");
$t3 = mysqli_num_rows($resultado3);
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Registrar Vehiculo</h1>
            <form action="registrar.php" id='demo' method="POST">
                <div class="form-group mb-3">
                    <label for="nombre">Patente</label>
                    <input placeholder="INGRESE PATENTE CON EL FORMATO: PP-PP-PP" class="form-control" type="text" name="patente" id="patente"   minlength="6" maxlength="6" size="10"  required>
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Tipo Vehiculo</label>

                    <select class="form-select" id="tipo" name="tipo" required>
                        <?php

                        if ($t >= 1) {
                            while ($row = $resultado->fetch_object()) {
                        ?>
                                <option value="<?php echo $row->id_tpv ?>"><?php echo $row->nombre_tpv ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Marca</label>

                    <select class="form-select" id="marca" name="marca" required>
                        <?php

                        if ($t2 >= 1) {
                            while ($row = $resultado2->fetch_object()) {
                        ?>
                                <option value="<?php echo $row->id_mv ?>"><?php echo $row->nombre_marca ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Cliente</label>

                    <select class="form-select" id="cliente" name="cliente" required>
                    <?php

                    if ($t3 >= 1) {
                        while ($row = $resultado3->fetch_object()) {
                    ?>
                            <option value="<?php echo $row->id_cliente ?>"><?php echo $row->n ?></option>
                    <?php
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                      <label for="obs" class="form-label">Observacion</label>
                      <textarea class="form-control" name="obs" id="obs" rows="6" style="resize: none;"></textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-success"  onclick="archiveFunction()">Guardar</button>
                    <a href="listar.php" class="btn btn-warning" style="float: right;">Volver</a>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script>
    
    function archiveFunction() {
        
event.preventDefault(); // prevent form submit
var form = event.target.form; // storing the form
    
Swal.fire({
  title: "Pregunta",
  text: "GENERAR TICKET DE ENTRADA?",
  type: "info",
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'Si',
  denyButtonText: `No`
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
      const url= 'demo.php';
    $.ajax({                        
           type: "POST",                 
           url: 'demo.php',                    
           data: $("#demo").serialize(),
           success: function(data)            
           {
               if(data == 'SI'){
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Ticket generado correctamente.',
                showConfirmButton: false,
                timer: 1500
                }),function(){ 
                    location.reload();
                }
               }else{
                Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Auto ingresado ya existe.',
                showConfirmButton: false,
                timer: 1500
                }),
                function(){ 
                    location.reload();
                }
               }    
           }
         });

    
  } else if (result.isDenied) {
    form.submit();
  }
})

    }
</script>
<script>
    const agregarCaracter = (cadena, caracter, pasos) => {
    let cadenaConCaracteres = "";
    const longitudCadena = cadena.length;
    for (let i = 0; i < longitudCadena; i += pasos) {
        if (i + pasos < longitudCadena) {
            cadenaConCaracteres += cadena.substring(i, i + pasos) + caracter;
        } else {
            cadenaConCaracteres += cadena.substring(i, longitudCadena);
        }
    }
    return cadenaConCaracteres;
}
$('#patente').change(function() {
    let texto = $('#patente').val();
    let patente = agregarCaracter(texto.toUpperCase(), '-',2)
    $('#patente').val(patente);
});
</script>




<?php include_once "pie.php"; ?>