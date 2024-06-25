<?php

    include '../config/config.php';
    
    $documento = $_POST["documento"];

    $sql = "SELECT * FROM usuarios WHERE documento ='".$documento."'";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'Usuario no encontrado, intente nuevamente.';
    }
    else{
        
        $reg = mysqli_fetch_array($resultado);

        $arrayJson['success'] = '1';
        $arrayJson['message'] = 'Usuario encontrado.';
        $arrayJson['id'] = $reg['id'];
        $arrayJson['documento'] = $reg['documento'];
        $arrayJson['nombres'] = $reg['nombres'];
        $arrayJson['apellidos'] = $reg['apellidos'];
        $arrayJson['telefono'] = $reg['telefono'];
        $arrayJson['email'] = $reg['email'];
        $arrayJson['password'] = $reg['password'];
        $arrayJson['is_active'] = $reg['is_active'];
        $arrayJson['rol'] = $reg['rol'];
        $arrayJson['created_at'] = $reg['created_at'];

    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);