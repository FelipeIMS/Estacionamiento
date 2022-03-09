<?php include 'settings.php'; //include settings 
                require __DIR__ . '/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
                use Mike42\Escpos\Printer;
                use Mike42\Escpos\EscposImage;
                use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
?>
<!DOCTYPE html>
<html lang="es">

<?php include('header.php') ?>
<title>Nuevo ingreso</title>

<body>
    <?php

    if (!empty($_POST['patente'])) {
        $search = mysqli_real_escape_string($conn, $_POST["patente"]);
        $registro2 = mysqli_query($conn, "SELECT  * FROM ficha f
        INNER JOIN  vehiculo v ON  v.patente = f.patente
        INNER JOIN  cliente c ON  c.id_cliente = v.cliente
        WHERE f.termino is null and v.patente='$search';"); 
        if (mysqli_num_rows($registro2) > 0) {
                echo "<script>  Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Error al ingresar ficha',
                    text: 'No puede ingresar ficha si no finaliza la anterior',
                    showConfirmButton: false,
                    timer: 1000
                  });</script>";
                echo '<script type="text/JavaScript"> setTimeout(function(){
                   window.location="index.php";
                }, 1000); </script>';
            } else {

                $sql = " INSERT INTO ficha(inicio,patente,espacio_ocupado,user_ficha, estado)  VALUES(now(),'$search',1,'{$_SESSION['id']}','No pagado')";
                $sql2="UPDATE cliente c
                JOIN vehiculo v  ON c.id_cliente = v.cliente
                SET c.estado= 'Inactivo'
                WHERE v.patente='$search';";
                mysqli_query($conn,$sql2);
                if (mysqli_query($conn, $sql)) {
                    echo "<script>  Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Registro ingresado',
                        text: 'Ficha ingresada correctamente',
                        showConfirmButton: false,
                        timer: 1000
                      });</script>";
                    echo '<script type="text/JavaScript"> setTimeout(function(){
                       window.location="index.php";
                    }, 1000); </script>';


                    $selectUltimo = "SELECT * from ficha order by id_ficha desc limit 1;";

                    $resultado = mysqli_query($conn, $selectUltimo);

                    $row = mysqli_fetch_array($resultado);

                }


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
$printer->text("Clinica Lircay" . "\n");
$printer->text( "\n");
$printer->text("Ticket  Entrada" . "\n");
$printer->text( "\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("Boleta N°: " . $row['id_ficha'] . "\n");
$printer->text( "\n");
$printer->text("Inicio: " . $row['inicio']  . "\n");



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
        
    }else{
        echo "<script>  Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Error',
            text: 'Ingrese datos nuevamente',
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