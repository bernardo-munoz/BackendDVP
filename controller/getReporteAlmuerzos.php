<?php

    include '../config/config.php';

    $sede = $_POST["sede"];
    $inicio = $_POST["inicio"];
    $fin = $_POST["fin"];

    if($sede == "General")
        $sql = "SELECT *, (SELECT CURTIME()) AS hora_actual FROM bie_plan_padrino_ventas WHERE fecha BETWEEN '".$inicio."' AND '".$fin."' GROUP BY documento, fecha ORDER BY id_venta";
    else
        $sql = "SELECT *, (SELECT CURTIME()) AS hora_actual FROM bie_plan_padrino_ventas WHERE sede = '".$sede."' AND fecha BETWEEN '".$inicio."' AND '".$fin."' GROUP BY documento, fecha ORDER BY id_venta";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
        $arrayJson[] = array(
            "success" => '0',
            "message" => 'No hay ventas registradas, intente nuevamente.'
        );
    }
    else{
        while($reg = mysqli_fetch_array($resultado))

        $arrayJson[] = array(
            "success" => "1",
            "message" => 'Ventas encontrados.',
            "num_ventas" => mysqli_num_rows($resultado),
            "id_venta" => $reg["id_venta"],
            "sede" => $reg["sede"],
            "documento" => $reg["documento"],
            "fecha" => $reg["fecha"],
            "hora" => $reg["hora"],
            "hora_actual" => $reg["hora_actual"]
        );
        
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);