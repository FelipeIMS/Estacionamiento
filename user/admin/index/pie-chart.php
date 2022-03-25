<?php
#Pie Chart
include '../settings.php';

$result = mysqli_query($conn,"SELECT * FROM espacios");

//$rows = array();
$rows['type'] = 'pie';
$rows['name'] = 'Revenue';
/* $rows['innerSize'] = '50%'; */
//$rows['innerSize'] = '50%';
while ($r = mysqli_fetch_array($result)) {
    $rows['data'][] = array($r['id'], $r['espacios']);
    $rows['data'][] = array($r['id'], $r['total_espacios']- $r['espacios']);   
}
$rslt = array();
array_push($rslt,$rows);
print json_encode($rslt, JSON_NUMERIC_CHECK);

mysqli_close($conn);

?>