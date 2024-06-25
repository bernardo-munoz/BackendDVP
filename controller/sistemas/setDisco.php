<?php

include 'config/conexion.php';

$placa_inventario = $_POST["placa_inventario"];
$marca_disco = $_POST["marca_disco"];
$id_disco = $_POST["id_disco"];
$capacidad = $_POST["capacidad"];
$tecnologia = $_POST["tecnologia"];

/*
$placa_inventario = "001-1245";
$id_tecnico = "0";
*/

$sql = "INSERT INTO discos VALUES('0','".$placa_inventario."','".$marca_disco."','".$id_disco."','".$capacidad."','".$tecnologia."',(SELECT NOW()))";

$resultado = mysqli_query($con, $sql);

if ($resultado == false){

    $arrayJson['success'] = '0';
    $arrayJson['message'] = "Error al registrar disco, intente nuevamente. ";
}
else{

    $arrayJson['success'] = '1';
    $arrayJson['message'] = "Disco registrado con exito.";

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
