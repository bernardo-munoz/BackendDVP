<?php

    include '../config/config.php';

    $working_day = $_POST["working_day"];
    $date = $_POST["date"];
    $state = $_POST["state"];
    
    $sql = "SELECT * FROM jornada_carnetizacion WHERE working_day = '".$working_day."' ;";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
       
        $sql = "INSERT INTO jornada_carnetizacion VALUES('0','".$working_day."', (SELECT NOW()), (SELECT NOW()), '1' );";
        $resultado = mysqli_query($con, $sql);

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Jornada no registrada, intente nuevamente.';

        } else {

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Jornada registrada con exito.';
        }
    }
    else{
        $reg = mysqli_fetch_array($resultado);

        $sql = "UPDATE jornada_carnetizacion SET working_day = '".$working_day."', updateAt = (SELECT NOW()) WHERE working_day = '".$working_day."' ;";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.';

        } else {

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Jornada actualizada con exito.';
        }
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
