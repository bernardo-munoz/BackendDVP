<?php

    include '../config/config.php';

    $documento = $_POST["documento"];
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $is_active = $_POST["estado"];
    $rol = $_POST["rol"];
    $password = sha1(md5($_POST["password"]));

    $sql = "SELECT * FROM usuarios WHERE documento = '".$documento."' OR email = '".$email."' ;";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
       
        $sql = "INSERT INTO usuarios VALUES('0','".$documento."','".$nombres."','".$apellidos."','".$telefono."','".$email."','".$password."','".$is_active."','".$rol."',(SELECT NOW()));";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Usuario no registrado, intente nuevamente.'.$sql;

        } else {

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Usuario registrado con exito.';

            $usuarios = mysqli_query($con, "SELECT * FROM usuarios ORDER BY id DESC LIMIT 1");
            
            $reg = mysqli_fetch_array($usuarios);
            
            $arrayJson['reg_id_usuario'] = $reg['id'];
            $arrayJson['created_at'] = $reg['created_at'];
        }
    }
    else{
        $reg = mysqli_fetch_array($resultado);

        if($_POST["password"] != $reg['password'])
            $password = sha1(md5($_POST["password"]));
        else
            $password = $_POST["password"];

        $sql = "UPDATE usuarios SET nombres = '".$nombres."', apellidos = '".$apellidos."', telefono = '".$telefono."', email = '".$email."', password = '".$password."', is_active = '".$is_active."', rol = '".$rol."' WHERE documento = '".$documento."' ;";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.';

        } else {

            $arrayJson['success'] = '2';
            $arrayJson['message'] = 'Usuario actualizado con exito.';
        }
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
