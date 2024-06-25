<?php

    include '../config/config.php';


    $id = $_POST["id"];
    $modulo = $_POST["modulo"];
    $rol = $_POST["rol"];

    $sql = "SELECT * FROM modulos WHERE id_modulo = '".$id."';";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
       
        $sql = "INSERT INTO modulos VALUES('0','".$modulo."','".$rol."');";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Modulo no registrado, intente nuevamente.'.$sql;

        } else {

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Modulo registrado con exito.';

            $modulos = mysqli_query($con, "SELECT * FROM modulos ORDER BY id DESC LIMIT 1");
            
            $reg = mysqli_fetch_array($modulos);
            
            $arrayJson['id_modulo'] = $reg['id'];
        }
    }
    else{
        $reg = mysqli_fetch_array($resultado);

        $sql = "UPDATE modulos SET modulo = '".$modulo."', rol = '".$rol."' WHERE id_modulo = '".$id."' ;";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.';

        } else {

            $arrayJson['success'] = '2';
            $arrayJson['message'] = 'Modulo actualizado con exito.';
        }
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
