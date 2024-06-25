<?php

include '../config/config.php';

$id_punto = $_POST["id_punto"];

$sql = "SELECT * FROM pos_gastos_variables WHERE id_punto = '".$id_punto."';";
$resultado = mysqli_query($con, $sql);

if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){

$arrayJson[] = array(
    "success" => '0',
    "message" => 'Informacion no encontrada, intente nuevamente.'
);
}
else{

while($reg = mysqli_fetch_array($resultado))
    $arrayJson[] = array(
        "success" => "1",
        "message" => 'Costos fijos de sueldos encontrados.',
        "id_gasto" => $reg["id_gasto"],
        "gv_detalle" => $reg["gv_detalle"],
        "gv_cantidad" => $reg["gv_cantidad"],
        "gv_valor_unitario" => $reg["gv_valor_unitario"],
        "gv_valor_total" => $reg["gv_valor_total"]
    );
}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);
?>