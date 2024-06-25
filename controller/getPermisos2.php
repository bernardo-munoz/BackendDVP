<?php

    include '../config/config.php';
    
    $documento = $_POST["documento"];

    $sql = "SELECT * FROM permisos WHERE documento ='".$documento."'";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows($resultado) === 0) {
        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'Permisos no encontrados, intente nuevamente.';
    } else {
        $arrayJson["success"] = '1';
        $arrayJson["message"] = 'Permisos encontrados.';
        $arrayJson["encontradas"] = mysqli_num_rows($resultado);
        // $arrayJson["sql"] = $sql;
    
        $data = array(); // Crear un array para almacenar los datos
    
        while ($reg = mysqli_fetch_array($resultado)) {
            $data[] = array(
                "id" => $reg["id"],
                "documento" => $reg["documento"],
                "id_rol" => $reg["id_rol"],
                "id_modulo" => $reg["id_modulo"],
                "guardar" => $reg["guardar"],
                "actualizar" => $reg["actualizar"],
                "eliminar" => $reg["eliminar"]
            );
        }
    
        $arrayJson["result"] = $data; // Asignar el array de datos a "result"
    }
    
    echo json_encode($arrayJson, JSON_FORCE_OBJECT);