<?php include_once "encabezado.php";
$mysqli = include_once "conexion.php";
$resultado = $mysqli->query("SELECT * FROM area ORDER BY nombre_area");
$t = mysqli_num_rows($resultado);

$resultado2 = $mysqli->query("SELECT * FROM convenios ORDER BY nombre_convenio");
$t2 = mysqli_num_rows($resultado2);
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Registrar Cliente</h1>
            <form action="registrar.php" method="POST">
                <div class="form-group mb-3">
                    <label for="nombre">RUT</label>
                    <input placeholder="" class="form-control" type="text" name="rut" id="rut" oninput="checkRut(this)">
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Nombres</label>
                    <input placeholder="" class="form-control" type="text" name="nombre" id="nombre" required>
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Apellidos</label>
                    <input placeholder="" class="form-control" type="text" name="apellidos" id="apellidos">
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Area</label>

                    <select class="form-select" id="area" name="area">
                        <?php

                        if ($t >= 1) {
                            while ($row = $resultado->fetch_object()) {
                        ?>
                                <option value="<?php echo $row->id_area ?>"><?php echo $row->nombre_area ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Default select example">Estado</label>
                    <select class="form-select mb-3" aria-label="Default select example" id="estado" name="estado">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Convenio</label>

                    <select class="form-select" id="convenio" name="convenio">
                        <?php

                        if ($t2 >= 1) {
                            while ($row = $resultado2->fetch_object()) {
                        ?>
                                <option value="<?php echo $row->id_convenio ?>"><?php echo $row->nombre_convenio ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <button class="btn btn-success">Guardar</button>
                    <a href="../index.php" class="btn btn-warning" style="float: right;">Atras</a>
                </div>


            </form>
        </div>
    </div>
</div>

<script>
    function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}
</script>

<?php include_once "pie.php"; ?>