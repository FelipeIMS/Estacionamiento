<?php
include_once "settings.php";
require '../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\CapabilityProfile;

$patente = $_POST['patente'];
$tipo = $_POST["tipo"];
$marca = $_POST["marca"];
$cliente = $_POST["cliente"];
$obs=$_POST['obs'];

$resultado3 = $conn->query("SELECT * FROM vehiculo  WHERE patente ='$patente'");

if (mysqli_num_rows($resultado3) > 0) {
    echo'NO';
}else{
    $estado = 'Activo';
    $sentencia = $conn->prepare("INSERT INTO vehiculo
    (patente,tipo_vehiculo,marca_vehiculo,cliente,estado_v,observacion)
    VALUES
    (?,?,?,?,?,?)");
    $sentencia->bind_param("siiiss", $patente, $tipo, $marca, $cliente, $estado,$obs);
    $sentencia->execute();

    $sql = " INSERT INTO ficha(inicio,patente,espacio_ocupado,user_ficha, estado)  VALUES(now(),'$patente',1,'{$_SESSION['id']}','No pagado')";
    $sql2="UPDATE cliente c
    JOIN vehiculo v  ON c.id_cliente = v.cliente
    SET c.estado= 'Inactivo', v.estado_v = 'Inactivo'
    WHERE v.patente='$patente';";
    mysqli_query($conn,$sql2);
    mysqli_query($conn, $sql);
    $selectUltimo = "SELECT * from ficha order by id_ficha desc limit 1;";
    $resultado = mysqli_query($conn, $selectUltimo);
    $row = mysqli_fetch_array($resultado);
    $espacios = "UPDATE espacios set espacios = espacios + 1  where id = 1;";
    $resultadoEspacios = mysqli_query($conn, $espacios);


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
    $printer->text("Ticket N°: " . $row['id_ficha'] . "\n");
    $printer->text( "\n");
    $printer->text("Inicio: " . $row['inicio']  . "\n");
    $printer->text( "\n");
    $printer->text("Patente: " . $row['patente']  . "\n");
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
    // $printer->pulse();

    /*
        Para imprimir realmente, tenemos que "cerrar"
        la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
    */
    $printer->close();

    echo 'SI';
    
}
    




?>