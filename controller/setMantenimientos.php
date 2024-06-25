<?php

include '../config/config.php';

$placa_inventario = $_POST["placa_inventario"];
$id_mantenimiento = $_POST["id_mantenimiento"];
$id_tecnico = $_POST["id_tecnico"];
$fecha = $_POST["fecha"];
$observaciones = $_POST["observaciones"];

$sql = "SELECT * FROM sis_mantenimientos WHERE id_mantenimiento = '".$id_mantenimiento."' ";
$resultado = mysqli_query($con, $sql);


if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){

    $sql = "INSERT INTO sis_mantenimientos VALUES('0','".$placa_inventario."','".$id_tecnico."','".$fecha."','".$observaciones."')";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al registrar mantenimiento, intente nuevamente.";
    }else{

        $sql = "SELECT id_mantenimiento FROM sis_mantenimientos ORDER BY id_mantenimiento DESC LIMIT 1 ";
        $resultado = mysqli_query($con, $sql);

        $reg = mysqli_fetch_array($resultado);


        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Mantenimiento registrado con exito.";
        $arrayJson['id_mantenimiento'] = $reg["id_mantenimiento"];
    }
}
else{

    $sql = "UPDATE sis_mantenimientos SET placa_inventario = '".$placa_inventario."', id_tecnico = '".$id_tecnico."', fecha = '".$fecha."', observaciones = '".$observaciones."' WHERE id_mantenimiento = '".$id_mantenimiento."' ";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al actualizar mantenimiento, intente nuevamente.";
    }else{
        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Mantenimiento actualizado con exito.";
    }

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
