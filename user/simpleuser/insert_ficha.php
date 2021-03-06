<?php include 'settings.php'; //include settings 
require 'autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\CapabilityProfile;


?>
<!DOCTYPE html>
<html lang="es">

<?php include('header.php') ?>
<title>Nuevo ingreso</title>

<body>
    <?php



    if (!empty($_POST['patente'])) {
        $search = mysqli_real_escape_string($conn, $_POST["patente"]);

        #Se llego al acuerdo de que la regla que decia que un cliente no puede tener mas de un auto se cancela. 
        // $registro2 = mysqli_query($conn, "SELECT id_cliente, cliente.nombre_cliente, cliente.apellido_cliente from cliente
        // inner join vehiculo on vehiculo.cliente = cliente.id_cliente
        // where cliente.estado = 'Inactivo' and vehiculo.patente = '$search';");
        // if (mysqli_num_rows($registro2) > 0) {echo "<script>  Swal.fire({
        //     position: 'center',
        //     icon: 'error',
        //     title: 'Error',
        //     text: 'Finalize el ingreso anterior',
        //     showConfirmButton: false,
        //     timer: 1000
        //   });</script>";
        //     echo '<script type="text/JavaScript"> setTimeout(function(){
        //    window.location="index.php";
        // }, 1000); </script>';
            
        //     }else

        #SELECCION ESTADO DE VEHICULO PARA COMPROBACION DE INGRESO.
        $select_estado_v = mysqli_query($conn, "SELECT * from vehiculo where patente ='$search' and estado_v = 'Inactivo';");
        $estado_v = mysqli_num_rows($select_estado_v);
        
        
        #COMPROBACION QUE ES UN CLIENTE CON CONVENIO GRATIS PARA NO DAR TICKET.
        $select_convenio_c = mysqli_query($conn, "SELECT patente, cliente, nombre_convenio from vehiculo
        INNER JOIN cliente on id_cliente = cliente
        INNER JOIN convenios on id_convenio = convenio
        where patente = '$search' AND nombre_convenio = 'Gratis';");
        $convenio_c = mysqli_num_rows($select_convenio_c);

        #COMPRPBACION DE EXISTENCIA PATENTE
        $selectPatente = mysqli_query($conn, "SELECT patente from vehiculo where patente = '$search';");
        $patente = $selectPatente->fetch_all(MYSQLI_ASSOC);

        if($estado_v >= 1){
            
            echo "<script>  Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error',
                    text: 'Finalize el ingreso anterior',
                    showConfirmButton: false,
                    timer: 1000
                  });</script>";
                    echo '<script type="text/JavaScript"> setTimeout(function(){
                   window.location="index.php";
                }, 1000); </script>';

        }else if($patente  == null){
                echo "<script>  Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error',
                    text: 'Patente ingresada no existe',
                    showConfirmButton: false,
                    timer: 1000
                  });</script>";
                    echo '<script type="text/JavaScript"> setTimeout(function(){
                   window.location="index.php";
                }, 1000); </script>';

        }else if($convenio_c >= 1){
            $sql = " INSERT INTO ficha(inicio,patente,espacio_ocupado,user_ficha, estado)  VALUES(now(),'$search',1,'{$_SESSION['id']}','No pagado')";
                $sql2="UPDATE cliente c
                JOIN vehiculo v  ON c.id_cliente = v.cliente
                SET c.estado= 'Inactivo', v.estado_v = 'Inactivo'
                WHERE v.patente='$search';";
                mysqli_query($conn,$sql2);
                mysqli_query($conn, $sql);
                $selectUltimo = "SELECT * from ficha order by id_ficha desc limit 1;";
                $resultado = mysqli_query($conn, $selectUltimo);
                $row = mysqli_fetch_array($resultado);
                $espacios = "UPDATE espacios set espacios = espacios + 1  where id = 1;";
                $resultadoEspacios = mysqli_query($conn, $espacios);
                echo "<script>  Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Hecho',
                    text: 'Nuevo ingreso agregado',
                    showConfirmButton: false,
                    timer: 1000
                  });</script>";
                    echo '<script type="text/JavaScript"> setTimeout(function(){
                   window.location="index.php";
                }, 1000); </script>';

        }else{
                $sql = " INSERT INTO ficha(inicio,patente,espacio_ocupado,user_ficha, estado)  VALUES(now(),'$search',1,'{$_SESSION['id']}','No pagado')";
                $sql2="UPDATE cliente c
                JOIN vehiculo v  ON c.id_cliente = v.cliente
                SET c.estado= 'Inactivo', v.estado_v = 'Inactivo'
                WHERE v.patente='$search';";
                mysqli_query($conn,$sql2);
                mysqli_query($conn, $sql);
                $selectUltimo = "SELECT * from ficha order by id_ficha desc limit 1;";
                $resultado = mysqli_query($conn, $selectUltimo);
                $row = mysqli_fetch_array($resultado);
                $espacios = "UPDATE espacios set espacios = espacios + 1  where id = 1;";
                $resultadoEspacios = mysqli_query($conn, $espacios);
                echo "<script>  Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Hecho',
                    text: 'Nuevo ingreso agregado',
                    showConfirmButton: false,
                    timer: 1000
                  });</script>";
                    echo '<script type="text/JavaScript"> setTimeout(function(){
                   window.location="index.php";
                }, 1000); </script>';


                $nombre_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $profile = CapabilityProfile::load("simple");
                $connector = new WindowsPrintConnector("smb://$nombre_host/boletas");
                $printer = new Printer($connector, $profile);
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("Inmobiliaria Lircay" . "\n");
                $printer->text("2 Poniente 1380, Talca" . "\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text( "\n");
                $printer->text("Ticket  Entrada" . "\n");
                $printer->text( "\n");
                $printer->text("Ticket N??: " . $row['id_ficha'] . "\n");
                $printer->text( "\n");
                $printer->text("Inicio: " . $row['inicio']  . "\n");
                $printer->text( "\n");
                $printer->text("Patente: " . $row['patente']  . "\n");
                $printer->text( "\n");
                $printer->text("Operador: " . $_SESSION['name']  . "\n");




                /*
                    Hacemos que el papel salga. Es como 
                    dejar muchos saltos de l??nea sin escribir nada
                */
                $printer->feed(8);



                /*
                    Cortamos el papel. Si nuestra impresora
                    no tiene soporte para ello, no generar??
                    ning??n error
                */
                $printer->cut();

                /*
                    Por medio de la impresora mandamos un pulso.
                    Esto es ??til cuando la tenemos conectada
                    por ejemplo a un caj??n
                */
                // $printer->pulse();

                /*
                    Para imprimir realmente, tenemos que "cerrar"
                    la conexi??n con la impresora. Recuerda incluir esto al final de todos los archivos
                */
                $printer->close();
                
            }



    }else{
        echo "<script>  Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Error',
            text: 'Rellene todos los campos',
            showConfirmButton: false,
            timer: 1000
          });</script>";
            echo '<script type="text/JavaScript"> setTimeout(function(){
           window.location="index.php";
        }, 1000); </script>';
    }
                

               
        
    




    ?>

</body>
<?php include('footer.php'); ?>


</html>