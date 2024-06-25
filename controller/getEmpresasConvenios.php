<?php

    include '../config/config.php';

    $sql = "SELECT * FROM empresas_convenios ORDER BY fecha_registro;";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
        $arrayJson[] = array(
            "success" => '0',
            "message" => 'No hay empresas registradas aún.'
        );
    }
    else{
        while($reg = mysqli_fetch_array($resultado))

        $arrayJson[] = array(
            "success" => "1",
            "message" => 'Empresas encontradas.',
            "razon_social" => $reg["razon_social"],
            "nit" => $reg["nit"],
            "representante" => $reg["representante"],
            "correo" => $reg["correo"],
            "telefono" => $reg["telefono"],
            "fecha_registro" => $reg["fecha_registro"],
            "estado" => $reg["estado"]
        );
        
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);