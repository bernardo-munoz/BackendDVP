<?php

include '../config/config.php';

$placa_inventario = $_POST["placa_inventario"];
//$placa_inventario = "321-11485";

$sql = "SELECT * FROM sis_discos WHERE placa_inventario = '".$placa_inventario."' ";
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
            "message" => 'Discos encontrados.',
            "id" => $reg["id"],
            "marca" => $reg["marca"],
            "id_disco" => $reg["id_disco"],
            "capacidad" => $reg["capacidad"],
            "tecnologia" => $reg["tecnologia"],
            "fecha" => $reg["fecha"]
        );
}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);
?>
