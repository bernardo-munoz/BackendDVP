<?php

include '../config/config.php';

$id = $_POST["id"];
$placa_inventario = $_POST["placa_inventario"];
$marca_disco = $_POST["marca_disco"];
$id_disco = $_POST["id_disco"];
$capacidad = $_POST["capacidad"];
$tecnologia = $_POST["tecnologia"];
$fecha = $_POST["fecha"];

$sql = "SELECT * FROM sis_discos WHERE id = '".$id."' ";
$resultado = mysqli_query($con, $sql);


if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){

    $sql = "INSERT INTO sis_discos VALUES('0','".$placa_inventario."','".$marca_disco."','".$id_disco."','".$capacidad."','".$tecnologia."','".$fecha."')";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al registrar disco, intente nuevamente.";
    }else{
        
        $sql = "SELECT id FROM sis_discos ORDER BY id DESC LIMIT 1 ";
        $resultado = mysqli_query($con, $sql);

        $reg = mysqli_fetch_array($resultado);

        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Disco registrado con exito.";
        $arrayJson['id'] = $reg['id'];
    }
}
else{

    $sql = "UPDATE sis_discos SET placa_inventario = '".$placa_inventario."', marca = '".$marca_disco."', id_disco = '".$id_disco."', capacidad = '".$capacidad."', tecnologia = '".$tecnologia."', fecha = '".$fecha."' WHERE id = '".$id."' ";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al actualizar disco, intente nuevamente.".$sql;
    }else{
        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Disco actualizado con exito.";
    }

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
