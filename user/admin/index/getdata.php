<?php
include '../settings.php';



$male="SELECT  espacios FROM espacios";
$result_male=$conn->query($male);
$num_males=mysqli_num_rows($result_male);
$female="SELECT total_espacios FROM espacios";
$result_female=$conn->query($female);
$num_females=mysqli_num_rows($result_female);

$data=array();
$data[0]=$num_males;
$data[1]=$num_females;

$result_male->close();
$result_female->close();
$conn->close();

print json_encode($data);
?>