<?php

include '../config/config.php';

$placa_inventario = $_POST["placa_inventario"];

$sql = "SELECT * FROM sis_equipos WHERE placa_inventario = '".$placa_inventario."' ";
$resultado = mysqli_query($con, $sql);


if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
    $arrayJson['success'] = '0';
    $arrayJson['message'] = "No se encontró el equipo, intente nuevamente.";    
}
else{

    $sql = "DELETE FROM sis_equipos WHERE placa_inventario = '".$placa_inventario."'";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al eliminar el equipo, intente nuevamente.";
    }else{
        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Equipo eliminado con exito.";
    }

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
