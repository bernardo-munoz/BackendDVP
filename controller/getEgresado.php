<?php

    include '../config/config.php';
    
    $nit = $_POST["nit"];
    $documento = $_POST["documento"];

    $sql = "SELECT * FROM egresados_promociones WHERE cedula ='".$documento."'";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'Documento no figura como egresado.';
    }
    else{        

        $reg = mysqli_fetch_array($resultado);

        $arrayJson['success'] = '1';
        $arrayJson['message'] = 'Egresado encontrado.';
        $arrayJson['documento'] = $reg['documento'];
        $arrayJson['nombre'] = $reg['nombre'];
        $arrayJson['apellido'] = $reg['apellido'];
        $arrayJson['programa'] = $reg['programa'];
        $arrayJson['correo'] = $reg['correo'];
        $arrayJson['tipo'] = 'estudiante';

        $sql = "INSERT INTO egresados_consultas_empresas VALUES('0','".$nit."','".$documento."',(SELECT NOW()));";
        $resultado = mysqli_query($con, $sql);
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);