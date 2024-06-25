<?php

    include '../config/config.php';

    $sede = $_POST["sede"];
    $documento = $_POST["documento"];
    $id_user = $_POST["id_user"];


    if(isset($documento)){

        $sql = "SELECT * FROM bie_plan_padrino_ventas WHERE documento = '".$documento."' AND fecha = (SELECT CURDATE())";
        $resultado = mysqli_query($con, $sql);

        $cons ="SELECT valor FROM bie_preventa WHERE id = 1";
        $result = mysqli_query($con, $cons);

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $req = mysqli_fetch_object($result);
    
            $sql = "INSERT INTO bie_plan_padrino_ventas VALUES('0','".$sede."','".$documento."',(SELECT CURDATE()),(SELECT CURTIME()),'".$req->valor."','0','".$id_user."')";
            $resultado = mysqli_query($con, $sql);
        
            if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
        
                $arrayJson["success"] = '0';
                $arrayJson["message"] = 'Venta no registrada, intente nuevamente.';
        
            } else {
        
                $arrayJson['success'] = '1';
                $arrayJson['message'] = 'Venta registrada con exito.';

                $sql = "SELECT * FROM bie_plan_padrino_ventas WHERE documento = '".$documento."' AND fecha = (SELECT CURDATE())";
                $resultado = mysqli_query($con, $sql);

                $reg = mysqli_fetch_array($resultado);

                $arrayJson['id_venta'] = $reg[0];
                $arrayJson['fecha'] = $reg[3];
                $arrayJson['hora'] = $reg[4];
                $arrayJson['valor'] = $req->valor;
            }
    
        } else {
    
            $arrayJson['success'] = '0';
            $arrayJson['message'] = 'El estudiante ya tiene un almuerzo vendido en el dia de hoy.';
    
        }
        
    }else{
        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'Error de conexión, intente nuevamente.';
    }
    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
