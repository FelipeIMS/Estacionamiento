
    <?php
      include_once "encabezado.php";
      include '../settings.php';
      $patente = $_POST["patente"];
      $tipo = $_POST["tipo"];
      $marca = $_POST["marca"];
      $cliente = $_POST["cliente"];
      $obs = $_POST["obs"];
      if (!empty($_POST)) {

            $resultado = $conn->query("SELECT * FROM vehiculo  WHERE patente ='$patente'");
            if (mysqli_num_rows($resultado) > 0) {
                  echo '<script>toastr.error("Patente ya existe")</script>';
                  header("refresh: 1; url=formulario_registrar.php");
            } else {
                  $estado= 'Activo';
                  $sentencia = $conn->prepare("INSERT INTO vehiculo
          (patente, tipo_vehiculo,marca_vehiculo,cliente,estado_v, observacion)
          VALUES
          (?, ?,?,?,?,?)");
                  $sentencia->bind_param("siisss", $patente, $tipo, $marca, $cliente, $estado,$obs);
                  $sentencia->execute();
                  echo '<script>toastr.success("Vehiculo Registrado")</script>';
                  header("refresh: 1; url=listar.php");
            }
      }

      ?>
