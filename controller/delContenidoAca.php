<?php

    include '../config/config.php';


    $id_modulo = $_POST["id_modulo"];

    $sql = "SELECT * FROM pos_cont_aca WHERE id_modulo = '".$id_modulo."' ";
    $resultado = mysqli_query($con, $sql);
    
    
    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "No se encontró el modulo, intente nuevamente.";    
    }
    else{
    
        $sql = "DELETE FROM pos_cont_aca WHERE id_modulo = '".$id_modulo."'";
        $resultado = mysqli_query($con, $sql);
    
        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
            $arrayJson['success'] = '0';
            $arrayJson['message'] = "Error al eliminar modulo, intente nuevamente.";
        }else{
            $arrayJson['success'] = '1';
            $arrayJson['message'] = "Modulo eliminado con exito.";
        }
    
    }
    
    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
    
    
    ?>
    