<?php

    include '../config/config.php';

    $empresa = $_POST["empresa"];
    $estado = $_POST["estado"];

    $sql = "SELECT * FROM empresas_convenios WHERE nit = '".$empresa."';";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'Empresa no encontrada.';
       
    }
    else{

        $sql = "UPDATE empresas_convenios SET estado = '".$estado."' WHERE nit = '".$empresa."';";
        $resultado = mysqli_query($con, $sql);

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Error al intentar validar la empresa, intente nuevamente.';

        } else {

            $arrayJson['success'] = '1';
            
            if($estado == "1"){
                $arrayJson['message'] = 'Empresa verificada.';            
                $sql = "INSERT INTO permisos VALUES('0','".$empresa."','4','6','0','0','0');";
                $resultado = mysqli_query($con, $sql);
            }
            else
                $arrayJson['message'] = 'Empresa no verificada.';
        }        
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
