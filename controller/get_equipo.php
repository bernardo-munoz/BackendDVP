<?php

include '../config/config.php';


$placa_inventario = $_POST["placa_inventario"];
//$documento = "1";

$sql = "SELECT * FROM sis_equipos WHERE placa_inventario = '".$placa_inventario."';";

$resultado = mysqli_query($con, $sql);

if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

	$arrayJson["success"] = '0';
	$arrayJson["message"] = 'Equipo no encontrado, verifique la placa.';

} else {

	$reg = mysqli_fetch_array($resultado);

	$arrayJson['success'] = '1';
	$arrayJson['message'] = 'Equipo encontrado.';	
	$arrayJson["placa_inventario"] = $reg["placa_inventario"];
	$arrayJson["marca"] = $reg["marca"];
	$arrayJson["tipo_equipo"] = $reg["tipo_equipo"];
	$arrayJson["sede"] = $reg["sede"];
	$arrayJson["modelo_monitor"] = $reg["modelo_monitor"];
	$arrayJson["serial_monitor"] = $reg["serial_monitor"];
	$arrayJson["modelo_cpu"] = $reg["modelo_cpu"];
	$arrayJson["serial_cpu"] = $reg["serial_cpu"];
	$arrayJson["modelo_teclado"] = $reg["modelo_teclado"];//10
	$arrayJson["serial_teclado"] = $reg["serial_teclado"];
	$arrayJson["modelo_mouse"] = $reg["modelo_mouse"];
	$arrayJson["serial_mouse"] = $reg["serial_mouse"];
	$arrayJson["procesador"] = $reg["procesador"];
	$arrayJson["velocidad"] = $reg["velocidad"];
	$arrayJson["nombre_equipo"] = $reg["nombre_equipo"];
	$arrayJson["en_red"] = $reg["en_red"];
	$arrayJson["direccion_ip"] = $reg["direccion_ip"];
	$arrayJson["direccion_mac"] = $reg["direccion_mac"];
	$arrayJson["sistema_operativo"] = $reg["sistema_operativo"];
	$arrayJson["usuario_responsable"] = $reg["usuario_responsable"];
	$arrayJson["ubicacion"] = $reg["ubicacion"];
	$arrayJson["datemask"] = $reg["fecha"];
	$arrayJson["id_tecnico"] = $reg["id_tecnico"];

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>
