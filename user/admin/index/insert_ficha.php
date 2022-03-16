<?php include '../settings.php'; //include settings 
require '../autoload.php';

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
        $registro2 = mysqli_query($conn, "SELECT id_cliente, cliente.nombre_cliente, cliente.apellido_cliente from cliente
        inner join vehiculo on vehiculo.cliente = cliente.id_cliente
        where cliente.estado = 'Inactivo' and vehiculo.patente = '$search';");
<<<<<<< HEAD
        $selectPatente = mysqli_query($conn, "SELECT patente from vehiculo where patente = '$search';");
        $patente = $selectPatente->fetch_all(MYSQLI_ASSOC);
        if (mysqli_num_rows($registro2) > 0) {
            echo '<script>toastr.error("Error al ingresar, finalize la boleta anterior")</script>';
            header("refresh: 1; url=index.php");
            }else if($patente  == null) {
            echo '<script>toastr.error("Error al ingresar, patente ingresada no existe")</script>';
            header("refresh: 1; url=index.php");
            }else{
                $espacios = "UPDATE espacios set espacios = espacios + 1  where id = 1;";
                $resultadoEspacios = mysqli_query($conn, $espacios);
                $sql = " INSERT INTO ficha(inicio,patente,espacio_ocupado,user_ficha, estado)  VALUES(now(),'$search',1,'{$_SESSION['id']}','No pagado')";
                $sql2="UPDATE cliente c
                JOIN vehiculo v  ON c.id_cliente = v.cliente
                SET c.estado= 'Inactivo'
                WHERE v.patente='$search';";
                mysqli_query($conn,$sql2);
                mysqli_query($conn, $sql);
                $selectUltimo = "SELECT * from ficha order by id_ficha desc limit 1;";
                $resultado = mysqli_query($conn, $selectUltimo);
                $row = mysqli_fetch_array($resultado);



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
                $printer->text("Boleta N°: " . $row['id_ficha'] . "\n");
                $printer->text( "\n");
                $printer->text("Inicio: " . $row['inicio']  . "\n");
                $printer->text( "\n");
                $printer->text("Operador: " . $_SESSION['name']  . "\n");




                /*
                    Hacemos que el papel salga. Es como 
                    dejar muchos saltos de línea sin escribir nada
                */
                $printer->feed(8);



                /*
                    Cortamos el papel. Si nuestra impresora
                    no tiene soporte para ello, no generará
                    ningún error
                */
                $printer->cut();

                /*
                    Por medio de la impresora mandamos un pulso.
                    Esto es útil cuando la tenemos conectada
                    por ejemplo a un cajón
                */
                $printer->pulse();

                /*
                    Para imprimir realmente, tenemos que "cerrar"
                    la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
                */
                $printer->close();
                echo '<script>toastr.success("Boleta generada correctamente")</script>';
                header("refresh: 1; url=index.php");
            }



    }else{
        echo '<script>toastr.error("Error al ingresar, rellene todos los campos")</script>';
=======
        if (mysqli_num_rows($registro2) > 0) {
            echo '<script>toastr.error("Error al ingresar, finalize la boleta anterior")</script>';
            header("refresh: 1; url=index.php");
        } else {
            $espacios = "UPDATE espacios set espacios = espacios - 1  where id = 1;";
            $resultadoEspacios = mysqli_query($conn, $espacios);

            $sql = " INSERT INTO ficha(inicio,patente,espacio_ocupado,user_ficha, estado)  VALUES(now(),'$search',1,'{$_SESSION['id']}','No pagado')";
            $sql2 = "UPDATE cliente c
                JOIN vehiculo v  ON c.id_cliente = v.cliente
                SET c.estado= 'Inactivo'
                WHERE v.patente='$search';";
            mysqli_query($conn, $sql2);
            if (mysqli_query($conn, $sql)) {
                echo '<script>toastr.success("Ficha ingresada correctamente")</script>';
                header("refresh: 1; url=index.php");


                $selectUltimo = "SELECT * from ficha order by id_ficha desc limit 1;";

                $resultado = mysqli_query($conn, $selectUltimo);

                $row = mysqli_fetch_array($resultado);
            }

            $nombre_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $profile = CapabilityProfile::load("simple");
            $connector = new WindowsPrintConnector("smb://$nombre_host/boletas");
            $printer = new Printer($connector, $profile);

            /*
     Imprimimos un mensaje. Podemos usar
     el salto de línea o llamar muchas
     veces a $printer->text()
 */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Inmobiliaria Lircay" . "\n");
            $printer->text("2 Poniente 1380, Talca" . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("\n");
            $printer->text("Ticket  Entrada" . "\n");
            $printer->text("\n");
            $printer->text("Boleta N°: " . $row['id_ficha'] . "\n");
            $printer->text("\n");
            $printer->text("Inicio: " . $row['inicio']  . "\n");
            $printer->text("\n");
            $printer->text("Operador: " . $_SESSION['name']  . "\n");




            /*
     Hacemos que el papel salga. Es como 
     dejar muchos saltos de línea sin escribir nada
 */
            $printer->feed(8);



            /*
     Cortamos el papel. Si nuestra impresora
     no tiene soporte para ello, no generará
     ningún error
 */
            $printer->cut();

            /*
     Por medio de la impresora mandamos un pulso.
     Esto es útil cuando la tenemos conectada
     por ejemplo a un cajón
 */
            $printer->pulse();

            /*
     Para imprimir realmente, tenemos que "cerrar"
     la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
 */
            $printer->close();
        }
    } else {
        echo '<script>toastr.error("Error al ingresar nueva ficha")</script>';
>>>>>>> 041e535ef582cdecfb420406068376c91a2bf64b
        header("refresh: 1; url=index.php");
    }
                

               
        
    




    ?>

</body>
<?php include('footer.php'); ?>


</html>