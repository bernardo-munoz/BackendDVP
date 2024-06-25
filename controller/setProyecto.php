<?php

    include '../config/config.php';

    $nombre = $_POST["nombre"];
    $dependencia = $_POST["dependencia"];
    $ejecuta = $_POST["ejecuta"];
    $presenta = $_POST["presenta"];
    $ubicacion = $_POST["ubicacion"];
    $linea = $_POST["linea"];
    $fecha = $_POST["fecha"];
    $pepus = $_POST["pepus"];
    $valor = $_POST["valor"];
    $duracion = $_POST["duracion"];
    $descripcion = $_POST["descripcion"];
    $fuente = $_POST["fuente"];
    $ajuste_presupuestal = $_POST["ajuste_presupuestal"];
    $monto = $_POST["monto"];
    $objetivo_general = $_POST["objetivo_general"];
    $objetivo_especifico = $_POST["objetivo_especifico"];
    $metas_programadas = $_POST["metas_programadas"];
    $metas_ejecutadas = $_POST["metas_ejecutadas"];
    $url_proyecto = $_POST["url_proyecto"];
    $estado = $_POST["estado"];
    $id_usuario = $_POST["id_usuario"];


    if(isset($nombre)){
        $sql = "INSERT INTO pla_proyectos VALUES('0','".$nombre."','".$dependencia."','".$ejecuta."','".$presenta."','".$ubicacion."','".$linea."',(SELECT CURDATE()),'".$pepus."','".$valor."','".$duracion."','".$descripcion."','".$fuente."','".$ajuste_presupuestal."','".$monto."','".$objetivo_general."','".$objetivo_especifico."','".$metas_programadas."','".$metas_ejecutadas."','".$url_proyecto."','".$estado."',(SELECT NOW()),(SELECT NOW()),'".$id_usuario."')";
        $resultado = mysqli_query($con, $sql);
    
        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
    
            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Proyecto no registrado, intente nuevamente.'.$sql;
    
        } else {
    
            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Proyecto registrado con exito.';
    
        }
    }else{
        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'No se enviaron los parametros correctos.';
    }
    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
