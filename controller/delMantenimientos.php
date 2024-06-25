<?php

include '../config/config.php';

$id_mantenimiento = $_POST["id_mantenimiento"];

$sql = "SELECT * FROM sis_mantenimientos WHERE id_mantenimiento = '".$id_mantenimiento."' ";
$resultado = mysqli_query($con, $sql);


if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
    $arrayJson['success'] = '0';
    $arrayJson['message'] = "No se encontró el mantenimiento, intente nuevamente.";    
}
else{

    $sql = "DELETE FROM sis_mantenimientos WHERE id_mantenimiento = '".$id_mantenimiento."'";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al eliminar mantenimiento, intente nuevamente.";
    }else{
        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Mantenimiento eliminado con exito.";
    }

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
