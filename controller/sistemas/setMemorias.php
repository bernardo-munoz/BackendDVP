<?php

include 'config/conexion.php';

$placa_inventario = $_POST["placa_inventario"];
$capacidad = $_POST["capacidad"];
$tipo_memoria = $_POST["tipo_memoria"];

/*
$placa_inventario = "001-1245";
$id_tecnico = "0";
*/

$sql = "INSERT INTO memorias VALUES('0','".$placa_inventario."','".$capacidad."','".$tipo_memoria."',(SELECT NOW()))";

$resultado = mysqli_query($con, $sql);

if ($resultado == false){

    $arrayJson['success'] = '0';
    $arrayJson['message'] = "Error al registrar memoria, intente nuevamente. ";
}
else{

    $arrayJson['success'] = '1';
    $arrayJson['message'] = "Memoria registrada con exito.";

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
