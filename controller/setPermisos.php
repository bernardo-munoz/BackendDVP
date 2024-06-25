<?php

    include '../config/config.php';

    $documento = $_POST["documento"];
    $id_rol = $_POST["id_rol"];
    $id_modulo = $_POST["id_modulo"];
    $asignar = $_POST["asignar"];
    $guardar = $_POST["guardar"];
    $actualizar = $_POST["actualizar"];
    $eliminar = $_POST["eliminar"];
    
    $sql = "SELECT id_rol FROM roles WHERE rol = '".$id_rol."';";
    $resultado = mysqli_query($con, $sql);
    $reg = mysqli_fetch_array($resultado);
    $id_rol = $reg["id_rol"];

    $sql = "SELECT * FROM permisos WHERE documento = '".$documento."' AND id_modulo = '".$id_modulo."' ;";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
       
        $sql = "INSERT INTO permisos VALUES('0','".$documento."','".$id_rol."','".$id_modulo."','".$guardar."','".$actualizar."','".$eliminar."');";
        $resultado = mysqli_query($con, $sql);

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Perimsos no registrados, intente nuevamente.';

        } else {

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Perimsos registrados con exito.';
        }
    }
    else{
        $reg = mysqli_fetch_array($resultado);
        if($asignar)
            $sql = "UPDATE permisos SET guardar = '".$guardar."', actualizar = '".$actualizar."', eliminar = '".$eliminar."' WHERE documento = '".$documento."' AND id_modulo = '".$id_modulo."' ;";
        else
            $sql = "DELETE FROM permisos WHERE documento = '".$documento."' AND id_modulo = '".$id_modulo."';";
        
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["asignar"] = $asignar;
            $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.';

        } else {

            $arrayJson['success'] = '2';
            $arrayJson['message'] = 'Perimsos actualizados con exito.';
        }
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
