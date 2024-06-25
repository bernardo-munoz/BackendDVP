<?php

    include '../config/config.php';

    $id_punto = $_POST["id_punto"];

    $sql = "SELECT * FROM pos_cont_aca WHERE id_punto = '".$id_punto."';";
    $resultado = mysqli_query($con, $sql);
    
if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){

    $arrayJson[] = array(
        "success" => '0',
        "message" => 'Informacion no encontrada, intente nuevamente.'
    );
}
else{

    while($reg = mysqli_fetch_array($resultado))
        $arrayJson[] = array(
            "success" => "1",
            "message" => 'Contenidos academicos encontrados.',
            "id_modulo" => $reg["id_modulo"],
            "nombre_modulo" => $reg["nombre_modulo"],
            "recurso_fisico" => $reg["recurso_fisico"],
            "cant_horas" => $reg["cant_horas"],
            "categoria" => $reg["categoria"],
            "procedencia" => $reg["procedencia"],
            "fecha" => $reg["fecha"]
        );
}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);
?>