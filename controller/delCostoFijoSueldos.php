<?php

    include '../config/config.php';


    $id_sueldo = $_POST["id_sueldo"];

    $sql = "SELECT * FROM pos_costos_fijos_sueldos WHERE id_sueldo = '".$id_sueldo."' ";
    $resultado = mysqli_query($con, $sql);
    
    
    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "No se encontró costo fijo, intente nuevamente.";    
    }
    else{
    
        $sql = "DELETE FROM pos_costos_fijos_sueldos WHERE id_sueldo = '".$id_sueldo."'";
        $resultado = mysqli_query($con, $sql);
    
        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
            $arrayJson['success'] = '0';
            $arrayJson['message'] = "Error al eliminar costo fijo, intente nuevamente.";
        }else{
            $arrayJson['success'] = '1';
            $arrayJson['message'] = "Costo fijo eliminado con exito.";
        }
    
    }
    
    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
    
    
    ?>
    