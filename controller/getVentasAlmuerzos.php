<?php

    include '../config/config.php';

    $sede = $_POST["sede"];

    $sql = "SELECT *, (SELECT CURTIME()) AS hora_actual FROM bie_plan_padrino_ventas v INNER JOIN bie_plan_padrino_sedes s ON v.sede = s.sedeu WHERE sede = '".$sede."' AND fecha = (SELECT CURDATE());";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
        $arrayJson[] = array(
            "success" => '0',
            "message" => 'No hay ventas registradas.'
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
            "valor" => $reg["valor"],
            "estado" => $reg["estado"],
            "capacidad" => $reg["capacidad"],
            "hora_venta_inicio" => $reg["hora_venta_inicio"],
            "hora_venta_fin" => $reg["hora_venta_fin"],
            "hora_entrega_inicio" => $reg["hora_entrega_inicio"],
            "hora_entrega_fin" => $reg["hora_entrega_fin"],
            "hora_actual" => $reg["hora_actual"]
        );
        
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);