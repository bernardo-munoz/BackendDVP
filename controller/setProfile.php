<?php

    include '../config/config.php';

    $documento = $_POST["documento"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    //$password=sha1(md5(mysqli_real_escape_string($con,(strip_tags($_POST["password"],ENT_QUOTES)))));

    $sql = "SELECT * FROM usuarios WHERE documento = '".$documento."';";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
       
        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'Usuario no registrado, intente nuevamente.';
    }
    else{
        $reg = mysqli_fetch_array($resultado);

        if($_POST["password"] != $reg['password'])
            $password=sha1(md5(mysqli_real_escape_string($con,(strip_tags($_POST["password"],ENT_QUOTES)))));
        else
            $password = $reg['password'];

        $sql = "UPDATE usuarios SET telefono = '".$telefono."', email = '".$email."', password = '".$password."' WHERE documento = '".$documento."' ;";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.';

        } else {

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Usuario actualizado con exito.';
        }
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
