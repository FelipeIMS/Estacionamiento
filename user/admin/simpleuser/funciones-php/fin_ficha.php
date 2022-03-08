<?php 

function finalizar (){
    $accion = isset($_POST['accion'])?$_POST['accion']:"";
    $id= isset($_POST['id'])?$_POST['id']:"";
    $fin= isset($_POST['termino'])?$_POST['termino']:"";

    switch($accion){
        case("Finalizar"):
            if($fin==null){
                $sql = "UPDATE ficha set termino= now() where id_ficha = '$id'";
                $resultado = $conn -> query($sql);
                if($resultado){
                    echo "<script>  Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Salida registrada',
                        text:'Salida registrada correctamente',
                        showConfirmButton: false,
                        timer: 3000
                      });</script>";
                      echo '<script type="text/JavaScript"> setTimeout(function(){
                        window.location="../index.php";
                     }, 2000); </script>';
                }
            }else{
                echo "<script>  Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Error al registrar salida',
                    text: 'Salida registrada anteriormente',
                    showConfirmButton: false,
                    timer: 3000
                  });</script>";
                  echo '<script type="text/JavaScript"> setTimeout(function(){
                   window.location="index.php";
                }, 2000); </script>';
            }
            break;
        case("Eliminar"):
            $sql = "DELETE from incidencias WHERE id_incidencias = '$id'";
            $resultado = $conn -> query($sql);
            if($resultado){
                echo "<script>  Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'INCIDENCIA ELIMINADA',
                    text:'INCIDENCIA ELIMINADA EXITOSAMENTE',
                    showConfirmButton: false,
                    timer: 3000
                });</script>";
                echo '<script type="text/JavaScript"> setTimeout(function(){
                    window.location="index.php";
                }, 2000); </script>';
            }
            break;

    }

}

?>