<?php

include 'config/conexion.php';

$placa_inventario = $_POST["placa_inventario"];
$observaciones = $_POST["observaciones"];
$id_tecnico = $_POST["id_tecnico"];

/*
$placa_inventario = "001-1245";
$id_tecnico = "0";
*/

$sql = "INSERT INTO mantenimientos VALUES('0','".$placa_inventario."','".$id_tecnico."',(SELECT NOW()),'".$observaciones."' )";

$resultado = mysqli_query($con, $sql);

if ($resultado == false){

    $arrayJson['success'] = '0';
    $arrayJson['message'] = "Error al registrar mantenimiento, intente nuevamente. ".$sql;
}
else{

    $arrayJson['success'] = '1';
    $arrayJson['message'] = "Mantenimiento registrado con exito.";

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
