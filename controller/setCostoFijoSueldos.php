<?php

include '../config/config.php';

$id_sueldo = $_POST["id_sueldo"];
$id_punto = $_POST["id_punto"];
$detalle = $_POST["detalle"];
$cantidad = $_POST["cantidad"];
$valor_unitario = $_POST["valor_unitario"];
$valor_total = $_POST["valor_total"];

$sql = "SELECT * FROM pos_costos_fijos_sueldos WHERE id_sueldo = '".$id_sueldo."' ";
$resultado = mysqli_query($con, $sql);


if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){

    $sql = "INSERT INTO pos_costos_fijos_sueldos VALUES('0','".$id_punto."','".$detalle."','".$cantidad."','".$valor_unitario."','".$valor_total."')";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al registrar costo fijo sueldos, intente nuevamente.";
    }else{

        $sql = "SELECT id_sueldo FROM pos_costos_fijos_sueldos ORDER BY id_sueldo DESC LIMIT 1 ";
        $resultado = mysqli_query($con, $sql);

        $reg = mysqli_fetch_array($resultado);


        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Costo fijo sueldos registrado con exito.";
        $arrayJson['id_sueldo'] = $reg["id_sueldo"];
    }
}
else{

    $sql = "UPDATE pos_costos_fijos_sueldos SET cfsu_detalle = '".$detalle."', cfsu_cantidad = '".$cantidad."', cfsu_valor_unitario = '".$valor_unitario."', cfsu_valor_total = '".$valor_total."' WHERE id_sueldo = '".$id_sueldo."' ";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al actualizar costo fijo sueldos, intente nuevamente.";
    }else{
        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Costo fijo sueldos actualizado con exito.";
    }

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
