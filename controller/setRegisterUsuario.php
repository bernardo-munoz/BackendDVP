<?php

    include '../config/config.php';

    $documento = $_POST["documento"];
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $password = sha1(md5($_POST["password"]));
    $is_active = $_POST["is_active"];
    $rol = $_POST["rol"];

    $sql = "SELECT * FROM usuarios WHERE documento = '".$documento."';";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
       
        $sql = "INSERT INTO usuarios VALUES('0','".$documento."','".$nombres."','".$apellidos."','".$telefono."','".$email."','".$password."','0','0',(SELECT NOW()));";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Usuario no registrado, intente nuevamente.';

        } else {

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Usuario registrado con exito.';
        }
    }
    else{
        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'El usuario ya se encuentra registrado, comuniquese con el administrador.';
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
