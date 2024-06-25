<?php

include '../config/config.php';

$placa_inventario = $_POST["placa_inventario"];
$id_memoria = $_POST["id_memoria"];
$capacidad = $_POST["capacidad"];
$tipo_memoria = $_POST["tipo_memoria"];
$fecha = $_POST["fecha"];

$sql = "SELECT * FROM sis_memorias WHERE id_memoria = '".$id_memoria."' ";
$resultado = mysqli_query($con, $sql);


if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){

    $sql = "INSERT INTO sis_memorias VALUES('0','".$placa_inventario."','".$capacidad."','".$tipo_memoria."','".$fecha."')";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al registrar memoria, intente nuevamente.";
    }else{

        $sql = "SELECT id_memoria FROM sis_memorias ORDER BY id_memoria DESC LIMIT 1 ";
        $resultado = mysqli_query($con, $sql);

        $reg = mysqli_fetch_array($resultado);


        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Memoria registrada con exito.";
        $arrayJson['id_memoria'] = $reg["id_memoria"];
    }
}
else{

    $sql = "UPDATE sis_memorias SET placa_inventario = '".$placa_inventario."', capacidad_memoria = '".$capacidad."', tipo_memoria = '".$tipo_memoria."', fecha = '".$fecha."' WHERE id_memoria = '".$id_memoria."' ";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al actualizar memoria, intente nuevamente.";
    }else{
        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Memoria actualizada con exito.";
    }

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
