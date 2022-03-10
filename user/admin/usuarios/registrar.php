
<?php
include_once "encabezado.php";

include '../settings.php';
$name = $_POST["name"];
$login = $_POST["login"];
$password = $_POST["password"];
$newpass =md5($password);
$role = $_POST["role"];
$voucher = $_POST["voucher"];


$buscarmarca= mysqli_query($conn,"SELECT  * FROM USERS WHERE name='$name'");

if(mysqli_num_rows($buscarmarca)>0){
    echo '<script>toastr.error("Usuario ya existe  ")</script>';
    header("refresh: 1; url=listar.php");
}else{
    $sentencia = $conn->prepare("INSERT INTO users
    (name,login,password,role,permiso_voucher)
    VALUES
    (?,?,?,?,?)");
    $sentencia->bind_param("sssii",$name,$login,$newpass,$role,$voucher);
    $sentencia->execute();
    echo '<script>toastr.success("Registro OK ")</script>';
    header("refresh: 1; url=listar.php");
}
