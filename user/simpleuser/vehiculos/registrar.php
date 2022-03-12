
    <?php
      include_once "encabezado.php";
      $mysqli = include_once "conexion.php";
      $patente = $_POST["patente"];
      $tipo = $_POST["tipo"];
      $marca = $_POST["marca"];
      $cliente = $_POST["cliente"];
      $obs=$_POST['obs'];


      if (!empty($_POST)) {
            $resultado3 = $mysqli->query("SELECT * FROM vehiculo  WHERE patente ='$patente'");

            if (mysqli_num_rows($resultado3) > 0) {
                  echo "<script>    
            sweetAlert({
                  title:'Error al insertar!',
                  text: 'Patente ya existe en el sistema!',
                  type:'warning'
            },function(isConfirm){
                  alert('ok');
            });
            $('.swal2-confirm').click(function(){
                  window.location.href = 'listar.php';
            });
  </script>";
                  header("refresh: 2; url=listar.php");
            } else {
                  $estado = 'Activo';
                  $sentencia = $mysqli->prepare("INSERT INTO vehiculo
    (patente,tipo_vehiculo,marca_vehiculo,cliente,estado_v,observacion)
    VALUES
    (?,?,?,?,?,?)");
                  $sentencia->bind_param("siiiss", $patente, $tipo, $marca, $cliente, $estado,$obs);
                  $sentencia->execute();
                  echo "<script>    
            sweetAlert({
                  title:'OK!',
                  text: 'Registro correcto!',
                  type:'success'

            },function(isConfirm){
                  alert('ok');
            });
            $('.swal2-confirm').click(function(){
                  window.location.href = 'listar.php';
            });
  </script>";
                  header("refresh: 2; url=listar.php");
            }
      }
      ?>
