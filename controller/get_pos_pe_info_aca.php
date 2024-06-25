<?php

    include '../config/config.php';

    $id_punto = $_POST["id_punto"];

    $sql = "SELECT * FROM pos_punto_equi WHERE id_punto = '".$id_punto."';";
    $resultado = mysqli_query($con, $sql);
    
    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
    
        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'Curso no encontrado, verifique e intente nuevamente.';
    
    } else {
    
        $reg = mysqli_fetch_array($resultado);

        $arrayJson["success"] = '1';
        $arrayJson["message"] = 'Curso encontrado.';
        $arrayJson["tipo_programa"] = $reg["tipo_programa"];
        $arrayJson["nombre"] = $reg["nombre"];
        $arrayJson["codigo_snies"] = $reg["codigo_snies"];
        $arrayJson["periodo"] = $reg["periodo"];
        $arrayJson["presentacion"] = $reg["presentacion"];
        $arrayJson["justificacion"] = $reg["justificacion"];
        $arrayJson["general"] = $reg["general"];
        $arrayJson["especificos"] = $reg["especificos"];
        $arrayJson["dirigido"] = $reg["dirigido"];
        $arrayJson["requisitos"] = $reg["requisitos"];
        $arrayJson["metodologia"] = $reg["metodologia"];
        $arrayJson["evaluacion"] = $reg["evaluacion"];
        $arrayJson["cupos_total"] = $reg["cupos_total"];
        $arrayJson["cupos_externos"] = $reg["cupos_externos"];
        $arrayJson["cupos_estudiantes"] = $reg["cupos_estudiantes"];
        $arrayJson["cupos_egresados"] = $reg["cupos_egresados"];
        $arrayJson["cupos_docentes"] = $reg["cupos_docentes"];
        $arrayJson["num_encuentros"] = $reg["num_encuentros"];
        $arrayJson["num_horas_sem"] = $reg["num_horas_sem"];
        $arrayJson["viajes_cordoba"] = $reg["viajes_cordoba"];
        $arrayJson["viajes_costa"] = $reg["viajes_costa"];
        $arrayJson["viajes_interior"] = $reg["viajes_interior"];
        $arrayJson["num_modulos"] = $reg["num_modulos"];
        $arrayJson["num_horas_tutorias"] = $reg["num_horas_tutorias"];
        $arrayJson["num_horas_coordinador"] = $reg["num_horas_coordinador"];
        $arrayJson["horas_audiovisuales"] = $reg["horas_audiovisuales"];
        $arrayJson["horas_aula_clase"] = $reg["horas_aula_clase"];
        $arrayJson["horas_informatica"] = $reg["horas_informatica"];
        $arrayJson["horas_muzanga"] = $reg["horas_muzanga"];
        $arrayJson["horas_laboratorio"] = $reg["horas_laboratorio"];
        $arrayJson["gastos_laboratorio"] = $reg["gastos_laboratorio"];
        $arrayJson["gastos_transporte"] = $reg["gastos_transporte"];
        $arrayJson["publicidad_radial"] = $reg["publicidad_radial"];
        $arrayJson["publicidad_prensa"] = $reg["publicidad_prensa"];
        $arrayJson["publicidad_afiches"] = $reg["publicidad_afiches"];
        $arrayJson["publicidad_portafolios"] = $reg["publicidad_portafolios"];
        $arrayJson["publicidad_personalizada"] = $reg["publicidad_personalizada"];
        $arrayJson["publicidad_total"] = $reg["publicidad_total"];
        $arrayJson["valor_inscripcion"] = $reg["valor_inscripcion"];
        $arrayJson["valor_matricula"] = $reg["valor_matricula"];
        $arrayJson["vlr_dcto_estudiantes"] = $reg["vlr_dcto_estudiantes"];
        $arrayJson["vlr_dcto_egresados"] = $reg["vlr_dcto_egresados"];
        $arrayJson["vlr_dcto_docentes"] = $reg["vlr_dcto_docentes"];
        $arrayJson["vlr_dcto_externos"] = $reg["vlr_dcto_externos"];
    
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
