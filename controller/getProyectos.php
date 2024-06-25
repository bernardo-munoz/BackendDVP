<?php

    include '../config/config.php';

    $sql = "SELECT* FROM pla_proyectos;";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
        $arrayJson[] = array(
            "success" => '0',
            "message" => 'Proyectos no encontrados, intente nuevamente.'
        );
    }
    else{
        while($reg = mysqli_fetch_array($resultado))

        $arrayJson[] = array(
            "success" => "1",
            "message" => 'Proyectos encontrados.',
            "nombre" => $reg["nombre"],
            "dependencia" => $reg["dependencia"],
            "ejecuta" => $reg["ejecuta"],
            "presenta" => $reg["presenta"],
            "valor" => $reg["valor"],
            "fecha" => $reg["fecha"],
            "estado" => $reg["estado"]
        );
        
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);