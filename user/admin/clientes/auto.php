<?php

include '../settings.php'; 

    if(!isset($_GET['searchTerm'])){ 
        $json = [];
    }else{
        $search = $_GET['searchTerm'];
        $sql = "SELECT convenios.id_convenio, convenios.nombre_convenio FROM convenios 
                WHERE nombre_convenio LIKE '%".$search."%'
                LIMIT 10"; 
        $result = $conn->query($sql);
        $json = [];
        while($row = $result->fetch_assoc()){
            $json[] = ['id'=>$row['id_convenio'], 'text'=>$row['nombre_convenio']];
        }
    }

    echo json_encode($json);
