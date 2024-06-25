<?php

include '../config/config.php';

$id_gasto = $_POST["id_gasto"];
$id_punto = $_POST["id_punto"];
$detalle = $_POST["detalle"];
$cantidad = $_POST["cantidad"];
$valor_unitario = $_POST["valor_unitario"];
$valor_total = $_POST["valor_total"];

$sql = "SELECT * FROM pos_gastos_variables WHERE id_gasto = '".$id_gasto."' ";
$resultado = mysqli_query($con, $sql);


if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){

    $sql = "INSERT INTO pos_gastos_variables VALUES('0','".$id_punto."','".$detalle."','".$cantidad."','".$valor_unitario."','".$valor_total."')";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al registrar costo fijo sueldos, intente nuevamente.";
    }else{

        $sql = "SELECT id_gasto FROM pos_gastos_variables ORDER BY id_gasto DESC LIMIT 1 ";
        $resultado = mysqli_query($con, $sql);

        $reg = mysqli_fetch_array($resultado);


        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Costo fijo sueldos registrado con exito.";
        $arrayJson['id_gasto'] = $reg["id_gasto"];
    }
}
else{

    $sql = "UPDATE pos_gastos_variables SET gv_detalle = '".$detalle."', gv_cantidad = '".$cantidad."', gv_valor_unitario = '".$valor_unitario."', gv_valor_total = '".$valor_total."' WHERE id_gasto = '".$id_gasto."' ";
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
