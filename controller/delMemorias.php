<?php

include '../config/config.php';

$id_memoria = $_POST["id_memoria"];

$sql = "SELECT * FROM sis_memorias WHERE id_memoria = '".$id_memoria."' ";
$resultado = mysqli_query($con, $sql);


if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
    $arrayJson['success'] = '0';
    $arrayJson['message'] = "No se encontró la memoria, intente nuevamente.";    
}
else{

    $sql = "DELETE FROM sis_memorias WHERE id_memoria = '".$id_memoria."'";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al eliminar memoria, intente nuevamente.";
    }else{
        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Memoria eliminada con exito.";
    }

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
