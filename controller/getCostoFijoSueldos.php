<?php

include '../config/config.php';

$id_punto = $_POST["id_punto"];

$sql = "SELECT * FROM pos_costos_fijos_sueldos WHERE id_punto = '".$id_punto."';";
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
        "id_sueldo" => $reg["id_sueldo"],
        "cfsu_detalle" => $reg["cfsu_detalle"],
        "cfsu_cantidad" => $reg["cfsu_cantidad"],
        "cfsu_valor_unitario" => $reg["cfsu_valor_unitario"],
        "cfsu_valor_total" => $reg["cfsu_valor_total"]
    );
}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);
?>