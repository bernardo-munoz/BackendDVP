<?php

    include '../config/config.php';
    
    $documento = $_POST["documento"];

    $sql = "SELECT * FROM estudiantes WHERE documento ='".$documento."'";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

        $sql = "SELECT * FROM funcionarios WHERE documento ='".$documento."'";
        $resultado = mysqli_query($con, $sql);
        
        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Usuario no encontrado, intente nuevamente.';
        }
        else{
            $reg = mysqli_fetch_array($resultado);

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Funcionario encontrado.';
            $arrayJson['documento'] = $reg['documento'];
            $arrayJson['nombre'] = $reg['nombre'];
            $arrayJson['apellido'] = $reg['apellido'];
            $arrayJson['programa'] = $reg['dependencia'];
            $arrayJson['correo'] = $reg['correo'];
            $arrayJson['tipo'] = 'funcionario';
        }
    }
    else{
        
        $reg = mysqli_fetch_array($resultado);

        $arrayJson['success'] = '1';
        $arrayJson['message'] = 'Estudiante encontrado.';
        $arrayJson['documento'] = $reg['documento'];
        $arrayJson['nombre'] = $reg['nombre'];
        $arrayJson['apellido'] = $reg['apellido'];
        $arrayJson['programa'] = $reg['programa'];
        $arrayJson['correo'] = $reg['correo'];
        $arrayJson['tipo'] = 'estudiante';
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);