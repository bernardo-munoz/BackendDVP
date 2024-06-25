<?php

    include '../config/config.php';

    $id_punto = $_POST["id_punto"];
    $tipo_programa = $_POST["tipo_programa"];
    $nombre_curso = $_POST["nombre_curso"];
    $codigo_snies = $_POST["codigo_snies"];
    $periodo = $_POST["periodo"];
    $presentacion = $_POST["presentacion"];
    $justificacion = $_POST["justificacion"];
    $obj_general = $_POST["obj_general"];
    $objetivo_especifico = $_POST["objetivo_especifico"];
    $dirigido = $_POST["dirigido"];
    $requisitos = $_POST["requisitos"];
    $metodologia = $_POST["metodologia"];
    $evaluacion = $_POST["evaluacion"];
    $cupos_totales = $_POST["cupos_totales"];
    $cuposExternos = $_POST["cuposExternos"];
    $cuposEstudiantes = $_POST["cuposEstudiantes"];
    $cuposEgresados = $_POST["cuposEgresados"];
    $cuposDocentes = $_POST["cuposDocentes"];
    $numEncuentros = $_POST["numEncuentros"];
    /*
    $numHorasSem = $_POST["numHorasSem"];
    $viajesDocCordoba = $_POST["viajesDocCordoba"];
    $viajesDocCostaNorte = $_POST["viajesDocCostaNorte"];
    $viajesDocInterior = $_POST["viajesDocInterior"];
    $numModulos = $_POST["numModulos"];
    $numHorasTutorias = $_POST["numHorasTutorias"];
    $numHorasCoordinador = $_POST["numHorasCoordinador"];
    $horas_audiovisuales = $_POST["horas_audiovisuales"];
    $horas_clase = $_POST["horas_clase"];
    $horas_informatica = $_POST["horas_informatica"];
    $horas_muzanga = $_POST["horas_muzanga"];
    $horas_laboratorio = $_POST["horas_laboratorio"];
    $gastos_lab = $_POST["gastos_lab"];
    $gastos_transporte = $_POST["gastos_transporte"];
    $publicidad_radial = $_POST["publicidad_radial"];
    $publicidad_prensa = $_POST["publicidad_prensa"];
    $publicidad_afiches = $_POST["publicidad_afiches"];
    $publicidad_portafolios = $_POST["publicidad_portafolios"];
    $publicidad_redes = $_POST["publicidad_redes"];
    $publicidad_personalizada = $_POST["publicidad_personalizada"];
    $total_publicidad = $_POST["total_publicidad"];
    */

    $numHorasSem = "0";
    $viajesDocCordoba = "0";
    $viajesDocCostaNorte = "0";
    $viajesDocInterior = "0";
    $numModulos = "0";
    $numHorasTutorias = "0";
    $numHorasCoordinador = "0";
    $horas_audiovisuales = "0";
    $horas_clase = "0";
    $horas_informatica = "0";
    $horas_muzanga = "0";
    $horas_laboratorio = "0";
    $gastos_lab = "0";
    $gastos_transporte = "0";
    $publicidad_radial = "0";
    $publicidad_prensa = "0";
    $publicidad_afiches = "0";
    $publicidad_portafolios = "0";
    $publicidad_redes = "0";
    $publicidad_personalizada = "0";
    $total_publicidad = "0";

    
    $valor_inscripcion = $_POST["valor_inscripcion"];
    $valor_matricula = $_POST["valor_matricula"];
    $vlr_dcto_estudiantes = $_POST["vlr_dcto_estudiantes"];
    $vlr_dcto_egresados = $_POST["vlr_dcto_egresados"];
    $vlr_dcto_docentes = $_POST["vlr_dcto_docentes"];
    $vlr_dcto_externos = $_POST["vlr_dcto_externos"];

    $sql = "SELECT * FROM pos_punto_equi WHERE id_punto = '".$id_punto."';";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
       
        $sql = "INSERT INTO pos_punto_equi VALUES('0','".$tipo_programa."','".$nombre_curso."','".$codigo_snies."','".$periodo."','".$presentacion."','".$justificacion."','".$obj_general."','".$objetivo_especifico."','".$dirigido."','".$requisitos."','".$metodologia."','".$evaluacion."','".$cupos_totales."','".$cuposExternos."','".$cuposEstudiantes."','".$cuposEgresados."','".$cuposDocentes."','".$numEncuentros."','".$numHorasSem."','".$viajesDocCordoba."','".$viajesDocCostaNorte."','".$viajesDocInterior."','".$numModulos."','".$numHorasTutorias."','".$numHorasCoordinador."','".$horas_audiovisuales."','".$horas_clase."','".$horas_informatica."','".$horas_muzanga."','".$horas_laboratorio."','".$gastos_lab."','".$gastos_transporte."','".$publicidad_radial."','".$publicidad_prensa."','".$publicidad_afiches."','".$publicidad_portafolios."','".$publicidad_redes."','".$publicidad_personalizada."','".$total_publicidad."','".$valor_inscripcion."','".$valor_matricula."','".$vlr_dcto_estudiantes."','".$vlr_dcto_egresados."','".$vlr_dcto_docentes."','".$vlr_dcto_externos."',(SELECT NOW()),'1');";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Curso no registrado, intente nuevamente.'.$sql;

        } else {

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Curso registrado con exito.';

            $sql = "SELECT * FROM pos_punto_equi ORDER BY id_punto DESC LIMIT 1;";
            $resultado = mysqli_query($con, $sql);

            $reg = mysqli_fetch_array($resultado);
            $arrayJson['id_punto'] = $reg["id_punto"];
        }
    }
    else{
        $sql = "UPDATE pos_punto_equi SET tipo_programa = '".$tipo_programa."', nombre = '".$nombre_curso."', codigo_snies = '".$codigo_snies."', periodo = '".$periodo."', presentacion = '".$presentacion."', justificacion = '".$justificacion."', general = '".$obj_general."', especificos = '".$objetivo_especifico."', dirigido = '".$dirigido."', requisitos = '".$requisitos."', metodologia = '".$metodologia."', evaluacion = '".$evaluacion."', cupos_total = '".$cupos_totales."', cupos_externos = '".$cuposExternos."', cupos_estudiantes = '".$cuposEstudiantes."', cupos_egresados = '".$cuposEgresados."', cupos_docentes = '".$cuposDocentes."', num_encuentros = '".$numEncuentros."', num_horas_sem = '".$numHorasSem."', viajes_cordoba = '".$viajesDocCordoba."', viajes_costa = '".$viajesDocCostaNorte."', viajes_interior = '".$viajesDocInterior."', num_modulos = '".$numModulos."', num_horas_tutorias = '".$numHorasTutorias."', num_horas_coordinador = '".$numHorasCoordinador."', horas_audiovisuales = '".$horas_audiovisuales."', horas_aula_clase = '".$horas_clase."', horas_informatica = '".$horas_informatica."', horas_muzanga = '".$horas_muzanga."', horas_laboratorio = '".$horas_laboratorio."', gastos_laboratorio = '".$gastos_lab."', gastos_transporte = '".$gastos_transporte."', publicidad_radial = '".$publicidad_radial."', publicidad_prensa = '".$publicidad_prensa."', publicidad_afiches = '".$publicidad_afiches."', publicidad_portafolios = '".$publicidad_portafolios."', publicidad_personalizada = '".$publicidad_personalizada."', publicidad_redes = '".$publicidad_redes."', publicidad_total = '".$total_publicidad."', valor_inscripcion = '".$valor_inscripcion."', valor_matricula = '".$valor_matricula."', vlr_dcto_estudiantes = '".$vlr_dcto_estudiantes."', vlr_dcto_egresados = '".$vlr_dcto_egresados."', vlr_dcto_docentes = '".$vlr_dcto_docentes."', vlr_dcto_externos = '".$vlr_dcto_externos."'  WHERE id_punto = '".$id_punto."';";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Curso no actualizado, intente nuevamente.';

        } else {

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Curso actualizado con exito.';
        }
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
