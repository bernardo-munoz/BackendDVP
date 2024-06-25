<?php

include '../config/config.php';

$id_punto = $_POST["id_punto"];

$sql = "SELECT * FROM pos_costos_fijos_servicios WHERE id_punto = '".$id_punto."';";
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
        "message" => 'Costos fijos de servicios encontrados.',
        "id_servicio" => $reg["id_servicio"],
        "cfs_detalle" => $reg["cfs_detalle"],
        "cfs_meses" => $reg["cfs_meses"],
        "cfs_cantidad" => $reg["cfs_cantidad"],
        "cfs_valor_unitario" => $reg["cfs_valor_unitario"],
        "cfs_valor_total" => $reg["cfs_valor_total"]
    );
}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);
?>