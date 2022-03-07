<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pago realizado</title>
    <?php include('header.php') ?>
</head>

<body>

    <?php
    include 'settings.php';

    $id = $_POST["id"];
    $pago = $_POST["total"];
    $convenio_sn = $_POST["convenio_sn"];
    $convenio_t = $_POST["convenio_t"];
    $convenio_v = $_POST["convenio_v"];



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
    $estado_pago->bind_param("siii", $convenio_sn, $convenio_t, $convenio_v, $id);
    $estado_pago->execute();

    echo "<script>  Swal.fire({
    position: 'center',
    icon: 'success',
    title: 'Pago realizado correctamente',
    showConfirmButton: false,
    timer: 1000
  });</script>";
    echo '<script type="text/JavaScript"> setTimeout(function(){
   window.location="index.php";
}, 1000); </script>';


    ?>
    <?php

    require __DIR__ . '/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
    use Mike42\Escpos\Printer;
    use Mike42\Escpos\EscposImage;
    use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

    /*
     Este ejemplo imprime un hola mundo en una impresora de tickets
     en Windows.
     La impresora debe estar instalada como genérica y debe estar
     compartida
 */

    /*
     Conectamos con la impresora
 */


    /*
     Aquí, en lugar de "POS-58" (que es el nombre de mi impresora)
     escribe el nombre de la tuya. Recuerda que debes compartirla
     desde el panel de control
 */

    $nombre_impresora = "ZJ-58";


    $connector = new WindowsPrintConnector($nombre_impresora);
    $printer = new Printer($connector);

    /*
     Imprimimos un mensaje. Podemos usar
     el salto de línea o llamar muchas
     veces a $printer->text()
 */
    $printer->text(" Clinica Lircay" . "\n");
    $printer->text("Ticket  Salida" . "\n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);

    $printer->text("Boleta N°: " . $id . "\n");
    $printer->text("Inicio: " . $cliente3['inicio']  . "\n");
    $printer->text("Termino: " . $cliente3['termino'] . "\n");
    $printer->text("Minutos: " . $cliente3['diferencia']  . "\n");
    $printer->text("TOTAL: $" . $pago . "\n");


    /*
     Hacemos que el papel salga. Es como 
     dejar muchos saltos de línea sin escribir nada
 */
    $printer->feed();



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
    ?>





</body>

</html>