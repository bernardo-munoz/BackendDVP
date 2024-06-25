<?php

    include '../config/config.php';

    $edc_pregrado = $_POST["edc_pregrado"];
    $edc_especialista = $_POST["edc_especialista"];
    $edc_magister = $_POST["edc_magister"];
    $edc_doctorado = $_POST["edc_doctorado"];
    $pos_pregrado = $_POST["pos_pregrado"];
    $pos_especialista = $_POST["pos_especialista"];
    $pos_magister = $_POST["pos_magister"];
    $pos_doctorado = $_POST["pos_doctorado"];
    $tut_pregrado = $_POST["tut_pregrado"];
    $tut_especialista = $_POST["tut_especialista"];
    $tut_magister = $_POST["tut_magister"];
    $tut_doctorado = $_POST["tut_doctorado"];
    $cordoba = $_POST["cordoba"];
    $bolivar = $_POST["bolivar"];
    $atlantico = $_POST["atlantico"];
    $magdalena = $_POST["magdalena"];
    $cesar = $_POST["cesar"];
    $guajira = $_POST["guajira"];
    $interior = $_POST["interior"];
    $hon_coordinador = $_POST["hon_coordinador"];
    $hon_ofi_posgrado = $_POST["hon_ofi_posgrado"];
    $consumo_luminarias = $_POST["consumo_luminarias"];
    $consumo_ventilador = $_POST["consumo_ventilador"];
    $consumo_aire = $_POST["consumo_aire"];
    $consumo_aire_muzanga = $_POST["consumo_aire_muzanga"];
    $consumo_pc = $_POST["consumo_pc"];
    $valor_kwh = $_POST["valor_kwh"];
    $area_muzanga = $_POST["area_muzanga"];
    $area_audiovisuales = $_POST["area_audiovisuales"];
    $area_genesis = $_POST["area_genesis"];
    $area_aula = $_POST["area_aula"];
    $vlr_metro_cuadrado_hora = $_POST["vlr_metro_cuadrado_hora"];
    $vlr_muzanga_hora = $_POST["vlr_muzanga_hora"];
    $vlr_audiovisuales_hora = $_POST["vlr_audiovisuales_hora"];
    $vlr_genesis_hora = $_POST["vlr_genesis_hora"];
    $vlr_aula_hora = $_POST["vlr_aula_hora"];
    $vlr_video_beam_hora = $_POST["vlr_video_beam_hora"];
    $vlr_fotocopia = $_POST["vlr_fotocopia"];
    $vlr_anillado = $_POST["vlr_anillado"];
    $vlr_marcador_borrador = $_POST["vlr_marcador_borrador"];
    $vlr_diploma_edc = $_POST["vlr_diploma_edc"];
    $vlr_diploma_pos = $_POST["vlr_diploma_pos"];
    $vlr_cafe_agua = $_POST["vlr_cafe_agua"];
    $vlr_inscripcion = $_POST["vlr_inscripcion"];
    $vlr_matricula = $_POST["vlr_matricula"];

    $sql = "UPDATE pos_bc_base_calculo SET edc_pregrado = '".$edc_pregrado."', edc_especialista = '".$edc_especialista."', edc_magister = '".$edc_magister."', edc_doctorado = '".$edc_doctorado."', pos_pregrado = '".$pos_pregrado."', pos_especialista = '".$pos_especialista."', pos_magister = '".$pos_magister."', pos_doctorado = '".$pos_doctorado."', tut_pregrado = '".$tut_pregrado."', tut_especialista = '".$tut_especialista."', tut_magister = '".$tut_magister."', tut_doctorado = '".$tut_doctorado."', cordoba = '".$cordoba."', bolivar = '".$bolivar."', atlantico = '".$atlantico."', magdalena = '".$magdalena."', cesar = '".$cesar."', guajira = '".$guajira."', interior = '".$interior."', hon_coordinador = '".$hon_coordinador."', hon_ofi_posgrado = '".$hon_ofi_posgrado."', consumo_luminarias = '".$consumo_luminarias."', consumo_ventilador = '".$consumo_ventilador."', consumo_aire = '".$consumo_aire."', consumo_aire_muzanga = '".$consumo_aire_muzanga."', consumo_pc = '".$consumo_pc."', valor_kwh = '".$valor_kwh."', area_muzanga = '".$area_muzanga."', area_audiovisuales = '".$area_audiovisuales."', area_genesis = '".$area_genesis."', area_aula = '".$area_aula."', vlr_metro_cuadrado_hora = '".$vlr_metro_cuadrado_hora."', vlr_muzanga_hora = '".$vlr_muzanga_hora."', vlr_audiovisuales_hora = '".$vlr_audiovisuales_hora."', vlr_genesis_hora = '".$vlr_genesis_hora."', vlr_aula_hora = '".$vlr_aula_hora."', vlr_video_beam_hora = '".$vlr_video_beam_hora."', vlr_fotocopia = '".$vlr_fotocopia."', vlr_anillado = '".$vlr_anillado."', vlr_marcador_borrador = '".$vlr_marcador_borrador."', vlr_diploma_edc = '".$vlr_diploma_edc."', vlr_diploma_pos = '".$vlr_diploma_pos."', vlr_cafe_agua = '".$vlr_cafe_agua."', vlr_inscripcion = '".$vlr_inscripcion."', vlr_matricula = '".$vlr_matricula."';";
    $resultado = mysqli_query($con, $sql);  

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.'.$sql;

    } else {

        $arrayJson['success'] = '1';
        $arrayJson['message'] = 'Datos actualizados con exito.';
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);

    
