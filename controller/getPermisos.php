<?php

    include '../config/config.php';
    
    $documento = $_POST["documento"];

    $sql = "SELECT * FROM permisos WHERE documento ='".$documento."'";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
        $arrayJson[] = array(
            "success" => "0",
            "message" => 'El usuario aun no tiene permisos.');
    }
    else{
        
        while($reg = mysqli_fetch_array($resultado)){
            $arrayJson[] = array(
                "success" => "1",
                "message" => 'Permisos encontrados.',
                "id" => $reg["id"],
                "documento" => $reg["documento"],
                "id_rol" => $reg["id_rol"],
                "id_modulo" => $reg["id_modulo"],
                "guardar" => $reg["guardar"],
                "actualizar" => $reg["actualizar"],
                "eliminar" => $reg["eliminar"]
            );
        }


    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);