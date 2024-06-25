<?php

    include '../config/config.php';

    $razon_social = $_POST["razon_social"];
    $nit = $_POST["nit"];
    $representante = $_POST["representante"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $password = sha1(md5($_POST["password"]));

    $sql = "SELECT * FROM empresas_convenios WHERE nit = '".$nit."' OR correo = '".$email."';";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
        
        $sql = "INSERT INTO empresas_convenios VALUES('0','".$razon_social."','".$nit."','".$representante."','".$email."','".$telefono."','".$password."',(SELECT NOW()),'0' );";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Empresa no registrada, intente nuevamente.';

        } else {

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Solicitud enviada con exito, espere su confirmación.';

        }
    }
    else{

        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'El nit o correo ya aparece registrado.';
    }


    

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
