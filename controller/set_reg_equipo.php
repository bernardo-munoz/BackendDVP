<?php

include '../config/config.php';

$placa_inventario = $_POST["placa_inventario"];
$marca = $_POST["marca"];
$tipo_equipo = $_POST["tipo_equipo"];
$sede = $_POST["sede"];
$modelo_monitor = $_POST["modelo_monitor"];
$serial_monitor = $_POST["serial_monitor"];
$modelo_teclado = $_POST["modelo_teclado"];
$serial_teclado = $_POST["serial_teclado"];
$modelo_mouse = $_POST["modelo_mouse"];
$serial_mouse = $_POST["serial_mouse"];
$procesador = $_POST["procesador"];
$velocidad = $_POST["velocidad"];
$nombre_equipo = $_POST["nombre_equipo"];
$en_red = $_POST["en_red"];
$direccion_ip = $_POST["direccion_ip"];
$direccion_mac = $_POST["direccion_mac"];
$sistema_operativo = $_POST["sistema_operativo"];
$usuario_responsable = $_POST["usuario_responsable"];
$ubicacion = $_POST["ubicacion"];
$datemask = $_POST["datemask"];
$id_tecnico = $_POST["id_tecnico"];


$sql = "SELECT * FROM sis_equipos WHERE placa_inventario = '".$placa_inventario."';";
$resultado = mysqli_query($con, $sql);

if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

    $sql = "INSERT INTO sis_equipos VALUES('0', '".$placa_inventario."','".$marca."', '".$tipo_equipo."', '".$sede."', '".$modelo_monitor."', '".$serial_monitor."', '".$modelo_teclado."', '".$serial_teclado."', '".$modelo_mouse."','".$serial_mouse."','".$procesador."','".$velocidad."','".$nombre_equipo."','".$en_red."','".$direccion_ip."','".$direccion_mac."','".$sistema_operativo."','".$usuario_responsable."','".$ubicacion."','".$datemask."',(SELECT NOW()),'".$id_tecnico."',(SELECT NOW()),'".$id_tecnico."' )";
	$resultado = mysqli_query($con, $sql);

    if ($resultado == false){

        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al registrar equipo, intente nuevamente. ".mysqli_num_rows ( $resultado )."*";
    }
    else{

        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Equipo registrado con exito.";

    }

} else {

	$sql = "UPDATE sis_equipos SET marca = '".$marca."', tipo_equipo = '".$tipo_equipo."', sede = '".$sede."', modelo_monitor = '".$modelo_monitor."', serial_monitor = '".$serial_monitor."', modelo_teclado = '".$modelo_teclado."', serial_teclado = '".$serial_teclado."', modelo_mouse = '".$modelo_mouse."', serial_mouse = '".$serial_mouse."', procesador = '".$procesador."', velocidad = '".$velocidad."', nombre_equipo = '".$nombre_equipo."', en_red = '".$en_red."', direccion_ip = '".$direccion_ip."', direccion_mac = '".$direccion_mac."', sistema_operativo = '".$sistema_operativo."', usuario_responsable = '".$usuario_responsable."', ubicacion = '".$ubicacion."', fecha = '".$datemask."', fecha_actualizacion = (SELECT NOW()), id_tecnico_actualiza = '".$id_tecnico."' WHERE placa_inventario = '".$placa_inventario."' ";
	
	$resultado = mysqli_query($con, $sql);

    if ($resultado == false){

        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al actualizar equipo, intente nuevamente.".$sql;
    }
    else{

        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Equipo actualizado con exito.";
    }	

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
