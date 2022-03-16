<?php
 require ('../autoload.php'); //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
 use Mike42\Escpos\Printer;
 use Mike42\Escpos\EscposImage;
 use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
 use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
 use Mike42\Escpos\CapabilityProfile;
 
 $nombre_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$profile = CapabilityProfile::load("simple");
$connector = new WindowsPrintConnector("smb://$nombre_host/boletas");
 $printer = new Printer($connector, $profile);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pago realizado</title>
    <?php include('../index/header.php') ?>
</head>

<body>

    <?php
    include '../settings.php';

    $id = $_POST["id"];
    $pago = $_POST["total"];
    $convenio_sn = $_POST["convenio_sn"];
    $convenio_t = $_POST["convenio_t"];
    $convenio_v = $_POST["convenio_v"];
    $sii = $_POST["sii"];
    $totalsinDesc = $_POST["total2"];

    if($sii == 0){
        $sii = null;
        $espacios = "UPDATE espacios set espacios = espacios + 1  where id = 1;";
                $resultadoEspacios = mysqli_query($conn, $espacios);
        
        $numero_boleta = $conn->prepare("UPDATE ficha set boleta_sii = ? where id_ficha = ?;");
        $numero_boleta->bind_param("ii", $sii, $id);
        $numero_boleta->execute();
        #llamamos a toda la ficha para poder activar al cliente al momento de pagar.
    $sentencia3 = $conn->prepare("SELECT id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado, convenios.tiempo, ficha.convenio_sn, ficha.convenio_t, ficha.convenio_v from ficha
    inner join vehiculo on vehiculo.patente = ficha.patente
    inner join cliente on cliente.id_cliente = vehiculo.cliente
    inner join area on area.id_area = cliente.area
    inner join convenios on cliente.convenio = convenios.id_convenio
    WHERE id_ficha = ?");
        $sentencia3->bind_param("i", $id);
        $sentencia3->execute();
        $resultado3 = $sentencia3->get_result();
    
        # Obtenemos solo una fila, que será el CLIENTE a editar
        $cliente3 = $resultado3->fetch_assoc();
        if (!$cliente3) {
            exit("No hay resultados para ese ID");
        }
        #Reactivamos cliente, para habilitar patentes asociadas
        $activar_cliente = $conn->prepare("UPDATE cliente c
    JOIN vehiculo v ON c.id_cliente = v.cliente
    SET c.estado='Activo'
    WHERE v.patente='" . $cliente3['patente'] . "'");
        $activar_cliente->execute();
        $sentencia = $conn->prepare("UPDATE ficha SET
    total = ?
    WHERE id_ficha = ?");
        $sentencia->bind_param("ii", $pago, $id);
        $sentencia->execute();
    
        #Registramos el usuario que finalizara la salida
        $user_out = $conn->prepare("UPDATE ficha  SET user_ficha_out= '{$_SESSION['id']}' WHERE id_ficha= ?");
        $user_out->bind_param("i", $id);
        $user_out->execute();
    
        #cambiar estado de pago
    
        $estado_pago = $conn->prepare("UPDATE ficha  SET estado= 'Pagado' WHERE id_ficha= ?");
        $estado_pago->bind_param("i", $id);
        $estado_pago->execute();
    
    
    
        #Hacemos el update a los campos convenios_sn y convenios_t
    
        $estado_pago = $conn->prepare("UPDATE ficha  SET convenio_sn= ?, convenio_t= ?, convenio_v= ?, fecha_pago = now()  WHERE id_ficha= ?;");
        $estado_pago->bind_param("siii", $convenio_sn, $convenio_t, $convenio_v,$id);
        $estado_pago->execute();

        if($totalsinDesc == 0){
            $desc = $conn->prepare("UPDATE ficha  SET total_sindesc = ?  WHERE id_ficha= ?;");
        $desc->bind_param("ii", $totalsinDesc, $id);
        $desc->execute();

            echo '<script>toastr.success("Pago realizado correctamente")</script>';
            header("refresh: 1; url=../index/index.php");
         
        $contador=0;
    while($contador < 2){
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Inmobiliaria Lircay" . "\n");
            $printer->text("2 Poniente 1380, Talca" . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Ticket  Salida" . "\n");
        $printer->text("\n");
        $printer->text("Boleta N°: " . $id . "\n");
        $printer->text("\n");
        $printer->text("Inicio: " . $cliente3['inicio']  . "\n");
        $printer->text("\n");
        $printer->text("Termino: " . $cliente3['termino'] . "\n");
        $printer->text("\n");
        $printer->text("Minutos: " . $cliente3['diferencia']  . "\n");
        $printer->text("\n");
        $printer->text("Descuento: $" . $convenio_v  . "\n");
        $printer->text("\n");
        $printer->text("TOTAL: $" . $pago . "\n");
        $printer->text("\n");
        $printer->text("Operador: " . $_SESSION['name'] . "\n");
        $printer->feed(6);
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
        $contador++;
    
        }
        }else{
            $desc = $conn->prepare("UPDATE ficha  SET total_sindesc = ?  WHERE id_ficha= ?;");
        $desc->bind_param("ii", $totalsinDesc, $id);
        $desc->execute();
            echo '<script>toastr.success("Pago realizado correctamente")</script>';
            header("refresh: 1; url=../index/index.php");
         
        $contador=0;
    while($contador < 2){
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Inmobiliaria Lircay" . "\n");
            $printer->text("2 Poniente 1380, Talca" . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        
        $printer->text("Ticket  Salida" . "\n");
        $printer->text("\n");
        $printer->text("Boleta N°: " . $id . "\n");
        $printer->text("\n");
        $printer->text("Inicio: " . $cliente3['inicio']  . "\n");
        $printer->text("\n");
        $printer->text("Termino: " . $cliente3['termino'] . "\n");
        $printer->text("\n");
        $printer->text("Minutos: " . $cliente3['diferencia']  . "\n");
        $printer->text("\n");
        $printer->text("Neto: $" . $totalsinDesc  . "\n");
        $printer->text("\n");
        $printer->text("Descuento: $" . $convenio_v  . "\n");
        $printer->text("\n");
        $printer->text("TOTAL: $" . $pago . "\n");
        $printer->text("\n");
        $printer->text("Operador: " . $_SESSION['name'] . "\n");
        $printer->feed(6);
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
        $contador++;
    
        }

        }
    

        

     

    /*
     Imprimimos un mensaje. Podemos usar
     el salto de línea o llamar muchas
     veces a $printer->text()
 */
    
    }else{
        $select_boleta =  $conn->query("SELECT  * FROM ficha WHERE boleta_sii = '".$sii."'");

        if(mysqli_num_rows($select_boleta)>0){


            #cambiar valores a null

            $restaurar = $conn->prepare("UPDATE ficha  SET termino= null, user_ficha_out = null, total= null, diferencia = null, convenio_v= null, total_sindesc = null WHERE id_ficha= ?");
            $restaurar->bind_param("i", $id);
            $restaurar->execute();
            echo '<script>toastr.error("Error, numero de boleta ya existe")</script>';
           
            $printer->close();
            header("refresh: 1; url=../index/index.php");

        }else{
            $espacios = "UPDATE espacios set espacios = espacios + 1  where id = 1;";
                $resultadoEspacios = mysqli_query($conn, $espacios);

            $numero_boleta = $conn->prepare("UPDATE ficha set boleta_sii = ? where id_ficha = ?;");
            $numero_boleta->bind_param("ii", $sii, $id);
            $numero_boleta->execute();

            #llamamos a toda la ficha para poder activar al cliente al momento de pagar.
            $sentencia3 = $conn->prepare("SELECT id_ficha, cliente.nombre_cliente, cliente.apellido_cliente,vehiculo.patente,area.nombre_area,  inicio, termino, diferencia,total, convenios.nombre_convenio as convenion, ficha.estado, convenios.tiempo, ficha.convenio_sn, ficha.convenio_t, ficha.convenio_v from ficha
            inner join vehiculo on vehiculo.patente = ficha.patente
            inner join cliente on cliente.id_cliente = vehiculo.cliente
            inner join area on area.id_area = cliente.area
            inner join convenios on cliente.convenio = convenios.id_convenio
            WHERE id_ficha = ?");
            $sentencia3->bind_param("i", $id);
            $sentencia3->execute();
            $resultado3 = $sentencia3->get_result();
        
            # Obtenemos solo una fila, que será el CLIENTE a editar
            $cliente3 = $resultado3->fetch_assoc();
            if (!$cliente3) {
                exit("No hay resultados para ese ID");
            }
            #Reactivamos cliente, para habilitar patentes asociadas
            $activar_cliente = $conn->prepare("UPDATE cliente c
            JOIN vehiculo v ON c.id_cliente = v.cliente
            SET c.estado='Activo'
            WHERE v.patente='" . $cliente3['patente'] . "'");
            $activar_cliente->execute();
            $sentencia = $conn->prepare("UPDATE ficha SET
            total = ?
            WHERE id_ficha = ?");
            $sentencia->bind_param("ii", $pago, $id);
            $sentencia->execute();
        
            #Registramos el usuario que finalizara la salida
            $user_out = $conn->prepare("UPDATE ficha  SET user_ficha_out= '{$_SESSION['id']}' WHERE id_ficha= ?");
            $user_out->bind_param("i", $id);
            $user_out->execute();
        
            #cambiar estado de pago
        
            $estado_pago = $conn->prepare("UPDATE ficha  SET estado= 'Pagado' WHERE id_ficha= ?");
            $estado_pago->bind_param("i", $id);
            $estado_pago->execute();
        
        
        
            #Hacemos el update a los campos convenios_sn y convenios_t
        
            $estado_pago = $conn->prepare("UPDATE ficha  SET convenio_sn= ?, convenio_t= ?, convenio_v= ?, fecha_pago = now(), boleta_sii = ?  WHERE id_ficha= ?;");
            $estado_pago->bind_param("siiii", $convenio_sn, $convenio_t, $convenio_v, $sii,$id);
            $estado_pago->execute();
        
            echo '<script>toastr.success("Pago realizado correctamente")</script>';
            header("refresh: 1; url=../index/index.php");
            if($totalsinDesc == 0){
                $desc = $conn->prepare("UPDATE ficha  SET total_sindesc = ?  WHERE id_ficha= ?;");
        $desc->bind_param("ii", $totalsinDesc, $id);
        $desc->execute();
             
            $contador=0;
        while($contador < 2){
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("Inmobiliaria Lircay" . "\n");
                $printer->text("2 Poniente 1380, Talca" . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Ticket  Salida" . "\n");
            $printer->text("\n");
            $printer->text("Boleta N°: " . $id . "\n");
            $printer->text("\n");
            $printer->text("Inicio: " . $cliente3['inicio']  . "\n");
            $printer->text("\n");
            $printer->text("Termino: " . $cliente3['termino'] . "\n");
            $printer->text("\n");
            $printer->text("Minutos: " . $cliente3['diferencia']  . "\n");
            $printer->text("\n");
            $printer->text("Descuento: $" . $convenio_v  . "\n");
            $printer->text("\n");
            $printer->text("TOTAL: $" . $pago . "\n");
            $printer->text("\n");
            $printer->text("Operador: " . $_SESSION['name'] . "\n");
            $printer->feed(6);
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
            $contador++;
        
            }
            }else{
                echo '<script>toastr.success("Pago realizado correctamente")</script>';
                header("refresh: 1; url=../index/index.php");
                $desc = $conn->prepare("UPDATE ficha  SET total_sindesc = ?  WHERE id_ficha= ?;");
        $desc->bind_param("ii", $totalsinDesc, $id);
        $desc->execute();
             
            $contador=0;
        while($contador < 2){
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("Inmobiliaria Lircay" . "\n");
                $printer->text("2 Poniente 1380, Talca" . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            
            $printer->text("Ticket  Salida" . "\n");
            $printer->text("\n");
            $printer->text("Boleta N°: " . $id . "\n");
            $printer->text("\n");
            $printer->text("Inicio: " . $cliente3['inicio']  . "\n");
            $printer->text("\n");
            $printer->text("Termino: " . $cliente3['termino'] . "\n");
            $printer->text("\n");
            $printer->text("Minutos: " . $cliente3['diferencia']  . "\n");
            $printer->text("\n");
            $printer->text("Neto: $" . $totalsinDesc  . "\n");
            $printer->text("\n");
            $printer->text("Descuento: $" . $convenio_v  . "\n");
            $printer->text("\n");
            $printer->text("TOTAL: $" . $pago . "\n");
            $printer->text("\n");
            $printer->text("Operador: " . $_SESSION['name'] . "\n");
            $printer->feed(6);
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
            $contador++;
        
            }
    
            }

        /*
     Imprimimos un mensaje. Podemos usar
     el salto de línea o llamar muchas
     veces a $printer->text()
     
 */

        }
    
    }



    


    ?>





</body>

</html>