<?php

include '../config/config.php';

$id_modulo = $_POST["id_modulo"];
$id_punto = $_POST["id_punto"];
$modulo = $_POST["modulo"];
$recurso_fisico = $_POST["recurso_fisico"];
$cant_horas = $_POST["cant_horas"];
$categoria = $_POST["categoria"];
$procedencia = $_POST["procedencia"];

$sql = "SELECT * FROM pos_cont_aca WHERE id_modulo = '".$id_modulo."' ";
$resultado = mysqli_query($con, $sql);


if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){

    $sql = "INSERT INTO pos_cont_aca VALUES('0','".$id_punto."','".$modulo."','".$recurso_fisico."','".$cant_horas."','".$categoria."','".$procedencia."', (SELECT NOW()) )";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al registrar modulo, intente nuevamente.";
    }else{

        $sql = "SELECT id_modulo FROM pos_cont_aca ORDER BY id_modulo DESC LIMIT 1 ";
        $resultado = mysqli_query($con, $sql);

        $reg = mysqli_fetch_array($resultado);


        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Modulo registrado con exito.";
        $arrayJson['id_modulo'] = $reg["id_modulo"];
    }
}
else{

    $sql = "UPDATE pos_cont_aca SET nombre_modulo = '".$modulo."', recurso_fisico = '".$recurso_fisico."', cant_horas = '".$cant_horas."', categoria = '".$categoria."', procedencia = '".$procedencia."' WHERE id_modulo = '".$id_modulo."' ";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al actualizar modulo, intente nuevamente.";
    }else{
        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Modulo actualizado con exito.";
    }

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
