<?php

include '../config/config.php';

$id_punto = $_POST["id_punto"];
$id_servicio = $_POST["id_servicio"];
$detalle = $_POST["detalle"];
$meses = $_POST["meses"];
$cant_horas = $_POST["cant_horas"];
$valor_unitario = $_POST["valor_unitario"];
$valor_total = $_POST["valor_total"];

$sql = "SELECT * FROM pos_costos_fijos_servicios WHERE id_servicio = '".$id_servicio."' ";
$resultado = mysqli_query($con, $sql);


if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){

    $sql = "INSERT INTO pos_costos_fijos_servicios VALUES('0','".$id_punto."','".$detalle."','".$meses."','".$cant_horas."','".$valor_unitario."','".$valor_total."')";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al registrar costo fijo, intente nuevamente.";
    }else{

        $sql = "SELECT id_servicio FROM pos_costos_fijos_servicios ORDER BY id_servicio DESC LIMIT 1 ";
        $resultado = mysqli_query($con, $sql);

        $reg = mysqli_fetch_array($resultado);


        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Costo fijo registrado con exito.";
        $arrayJson['id_servicio'] = $reg["id_servicio"];
    }
}
else{

    $sql = "UPDATE pos_costos_fijos_servicios SET cfs_detalle = '".$detalle."', cfs_meses = '".$meses."', cfs_cantidad = '".$cant_horas."', cfs_valor_unitario = '".$valor_unitario."', cfs_valor_total = '".$valor_total."' WHERE id_servicio = '".$id_servicio."' ";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al actualizar costo fijo, intente nuevamente.";
    }else{
        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Costo fijo actualizado con exito.";
    }

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
