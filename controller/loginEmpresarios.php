<?php
	session_start();

	include '../config/config.php';
	require_once '../clases/empresa.php';
	require_once '../config/session.php';

	$nit=mysqli_real_escape_string($con,(strip_tags($_POST["nit"],ENT_QUOTES)));
	$password=sha1(md5(mysqli_real_escape_string($con,(strip_tags($_POST["pass"],ENT_QUOTES)))));

	$sql = "SELECT * FROM empresas_convenios WHERE nit = '".$nit."';";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
		$arrayJson["success"] = "0";
		$arrayJson["message"] = "Empresa no encontrada, intente nuevamente.";
    }
    else{
        $reg = mysqli_fetch_array($resultado);

		if($reg[6] != $password){
			$arrayJson["success"] = "0";
			$arrayJson["message"] = "Contrasñea incorrecta, intente nuevamente.";
		}else if($reg['estado'] == "0"){
			$arrayJson["success"] = "0";
			$arrayJson["message"] = "La cuenta esta inactiva";
		}else{
			
			$empresa = new Empresa($reg['nit']);
			$session = new Session();

			$empresa->saveSession($session->getSession());

			$arrayJson["success"] = "1";
			$arrayJson["message"] = "Bienvenido ".$reg["razon_social"];
			$arrayJson["encontrados"] = mysqli_num_rows ( $resultado );
			$arrayJson["id_empresa"] = $reg["id_empresa"];
			$arrayJson['razon_social'] = $reg['razon_social'];
			$arrayJson['nit'] = $reg['nit'];
			$arrayJson['representante'] = $reg['representante'];
			$arrayJson['telefono'] = $reg['telefono'];
			$arrayJson['email'] = $reg['email'];
			$arrayJson['password'] = $reg[6];
			$arrayJson['estado'] = $reg['estado'];
		}
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);

?>