<?php
<<<<<<< Updated upstream
$host = "192.168.2.175:3306";
$usuario = "username";
$contrasenia = "password";
// $host = "localhost";
// $usuario = "root";
// $contrasenia = "";
=======
 $host = "192.168.2.175:3306";
 $usuario = "username";
$contrasenia = "password";
/* $host = "localhost";
$usuario = "root";
$contrasenia = ""; */
>>>>>>> Stashed changes
$base_de_datos = "estacionamiento";
$mysqli = new mysqli($host, $usuario, $contrasenia, $base_de_datos);
if ($mysqli->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
return $mysqli;
