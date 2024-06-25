<?php

include 'config/conexion.php';

$marca = $_POST["marca"];
$proveedor = $_POST["proveedor"];
$modelo = $_POST["modelo"];
$placa_inventario = $_POST["placa_inventario"];
$modelo_monitor = $_POST["modelo_monitor"];
$serial_monitor = $_POST["serial_monitor"];
$modelo_cpu = $_POST["modelo_cpu"];
$serial_cpu = $_POST["serial_cpu"];
$modelo_teclado = $_POST["modelo_teclado"];//10
$serial_teclado = $_POST["serial_teclado"];
$modelo_mouse = $_POST["modelo_mouse"];
$serial_mouse = $_POST["serial_mouse"];
$procesador = $_POST["procesador"];
$velocidad = $_POST["velocidad"];
$ram = $_POST["ram"];
$marca_disco = $_POST["marca_disco"];
$capacidad = $_POST["capacidad"];
$tecnologia = $_POST["tecnologia"];
$nombre_equipo = $_POST["nombre_equipo"];
$en_red = $_POST["en_red"];
$direccion_ip = $_POST["direccion_ip"];
$direccion_mac = $_POST["direccion_mac"];
$sistema_operativo = $_POST["sistema_operativo"];
$usuario_responsable = $_POST["usuario_responsable"];
$ubicacion = $_POST["ubicacion"];
$fecha = $_POST["datemask"];
$id_tecnico = $_POST["id_tecnico"];

/*
$marca = "algo";
$proveedor = "algo";
$modelo = "algo";
$placa_inventario = "algo";
$modelo_monitor = "algo";
$serial_monitor = "algo";
$modelo_cpu = "algo";
$serial_cpu = "algo";
$modelo_teclado = "algo";
$serial_teclado = "algo";
$modelo_mouse = "algo";
$serial_mouse = "algo";
$procesador = "algo";
$velocidad = "algo";
$ram = "algo";
$marca_disco = "algo";
$capacidad = "algo";
$tecnologia = "algo";
$nombre_equipo = "algo";
$en_red = "1";
$direccion_ip = "algo";
$direccion_mac = "algo";
$sistema_operativo = "algo";
$usuario_responsable = "algo";
$ubicacion = "algo";
$fecha = "2000-01-01";
$id_tecnico = "0";
*/
//$documento = "1";

$sql = "SELECT * FROM equipos WHERE placa_inventario = '".$placa_inventario."';";

$resultado = mysqli_query($con, $sql);

if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

    $sql = "INSERT INTO equipos VALUES('0','".$marca."', '".$proveedor."', '".$modelo."', '".$placa_inventario."', '".$modelo_monitor."', '".$serial_monitor."', '".$modelo_cpu."', '".$serial_cpu."', '".$modelo_teclado."', '".$serial_teclado."', '".$modelo_mouse."','".$serial_mouse."','".$procesador."','".$velocidad."','".$ram."','".$marca_disco."','".$capacidad."','".$tecnologia."','".$nombre_equipo."','".$en_red."','".$direccion_ip."','".$direccion_mac."','".$sistema_operativo."','".$usuario_responsable."','".$ubicacion."','".$fecha."',(SELECT NOW()),'".$id_tecnico."',(SELECT NOW()),'".$id_tecnico."' )";

	$resultado = mysqli_query($con, $sql);

    if ($resultado == false){

        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al registrar equipo, intente nuevamente. ".$sql;
    }
    else{

        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Equipo registrado con exito.";

    }

} else {

	$sql = "UPDATE equipos SET marca = '".$marca."', proveedor = '".$proveedor."', modelo = '".$modelo."', modelo_monitor = '".$modelo_monitor."', serial_monitor = '".$serial_monitor."', modelo_cpu = '".$modelo_cpu."', serial_cpu = '".$serial_cpu."', modelo_teclado = '".$modelo_teclado."', serial_teclado = '".$serial_teclado."', modelo_mouse = '".$modelo_mouse."', serial_mouse = '".$serial_mouse."', procesador = '".$procesador."', velocidad = '".$velocidad."', ram = '".$ram."', marca_disco = '".$marca_disco."', capacidad = '".$capacidad."', tecnologia = '".$tecnologia."', nombre_equipo = '".$nombre_equipo."', en_red = '".$en_red."', direccion_ip = '".$direccion_ip."', direccion_mac = '".$direccion_mac."', sistema_operativo = '".$sistema_operativo."', usuario_responsable = '".$usuario_responsable."', ubicacion = '".$ubicacion."', fecha = '".$fecha."', fecha_actualizacion = (SELECT NOW()), id_tecnico_actualiza = '".$id_tecnico."' WHERE placa_inventario = '".$placa_inventario."' ";
	
	$resultado = mysqli_query($con, $sql);

    if ($resultado == false){

        $arrayJson['success'] = '0';
        $arrayJson['message'] = "Error al actualizar equipo, intente nuevamente.";
    }
    else{

        $arrayJson['success'] = '1';
        $arrayJson['message'] = "Equipo actualizado con exito.";
    }	

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
