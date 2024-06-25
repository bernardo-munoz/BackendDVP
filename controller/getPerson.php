<?php

    include '../config/config.php';
    
    $documento = $_POST["document"];

    $sql = "SELECT documento, nombre, apellido, programa, correo, 'Estudiante' AS tipo FROM estudiantes WHERE documento = '".$documento."'
            UNION ALL
            SELECT documento, nombre, apellido, dependencia AS programa, correo, 'Funcionario' AS tipo FROM funcionarios WHERE documento = '".$documento."' ";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'Usuario no encontrado, intente nuevamente.';
    }
    else {

        $arrayJson['success'] = '1';
        $arrayJson['message'] = 'Usuario encontrado.';
        $arrayJson['sql'] = $sql;
        $arrayJson["encontrados"] = mysqli_num_rows ( $resultado );
        
        $data = array(); // Crear un array para almacenar los datos
        
        while($reg = mysqli_fetch_array($resultado))
            $data[] = array(
                "document" => $reg["documento"],
                "name" => $reg["nombre"],
                "last_name" => $reg["apellido"],
                "program" => $reg["programa"],
                "email" => $reg["correo"],
                "type" => $reg["tipo"],
                "state" => "A",
                "stratum" => "2",
                "rh" => "O+"
            );
        
        $arrayJson["users"] = $data; // Asignar el array de datos a "result"
    }
    

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);