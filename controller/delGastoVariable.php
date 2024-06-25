<?php

    include '../config/config.php';


    $id_gasto = $_POST["id_gasto"];

    $sql = "SELECT * FROM pos_gastos_variables WHERE id_gasto = '".$id_gasto."' ";
    $resultado = mysqli_query($con, $sql);
    
    
    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
        $arrayJson['success'] = '0';
        $arrayJson['message'] = "No se encontró gasto variable, intente nuevamente.";    
    }
    else{
    
        $sql = "DELETE FROM pos_gastos_variables WHERE id_gasto = '".$id_gasto."'";
        $resultado = mysqli_query($con, $sql);
    
        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
            $arrayJson['success'] = '0';
            $arrayJson['message'] = "Error al eliminar gasto variable, intente nuevamente.";
        }else{
            $arrayJson['success'] = '1';
            $arrayJson['message'] = "Gasto variable eliminado con exito.";
        }
    
    }
    
    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
    
    
    ?>
    