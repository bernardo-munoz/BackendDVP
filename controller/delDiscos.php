<?php

include '../config/config.php';

$id = $_POST["id"];

$sql = "SELECT * FROM sis_discos WHERE id = '".$id."' ";
$resultado = mysqli_query($con, $sql);


if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
    $arrayJson['success'] = '0';
    $arrayJson['message'] = "No se encontró el disco, intente nuevamente.";    
}
else{

    $sql = "DELETE FROM sis_discos WHERE id = '".$id."'";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al eliminar el disco, intente nuevamente.";
    }else{
        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Disco eliminado con exito.";
    }

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
