

<?php

include 'settings.php';
$id = $_GET["id"];

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
$printer->text("TOTAL: $" . $cliente3['total'] . "\n");
$printer->text("\n");


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
header("refresh: 0; url=index.php");
?>