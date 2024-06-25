<?php

    include '../config/config.php';

    $sede = $_POST["sede"];
    $documento = $_POST["documento"];


    if(isset($documento)){

        $sql = "SELECT * FROM bie_plan_padrino_ventas WHERE documento = '".$documento."' AND fecha = (SELECT CURDATE()) AND sede = '".$sede."';";
        $resultado = mysqli_query($con, $sql);

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
    
            $arrayJson['success'] = '0';
            $arrayJson['message'] = 'El documento no tiene un almuerzo vendido en el dia de hoy en esta sede.';
    
        } else {
    
            $reg = mysqli_fetch_array($resultado);

            if($reg["estado"] == "1"){

                $arrayJson['success'] = '0';
                $arrayJson['message'] = 'El documento ya reclamo el almuerzo.';

            }else{
                
                $sql = "UPDATE bie_plan_padrino_ventas SET estado = '1' WHERE documento = '".$documento."' AND fecha = (SELECT CURDATE()) AND sede = '".$sede."'";
                $resultado = mysqli_query($con, $sql);
            
                if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
            
                    $arrayJson["success"] = '0';
                    $arrayJson["message"] = 'Entrega no realizada, intente nuevamente.';
            
                } else {

                    $arrayJson['success'] = '1';
                    $arrayJson['message'] = 'Entrega registrada con exito.';
                }
            }    
        }
        
    }else{
        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'Error de conexión, intente nuevamente.';
    }
    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
