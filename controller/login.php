<?php

require __DIR__ . '../../../vendor/autoload.php';
use \Firebase\JWT\JWT;

include '../config/config.php';


$document = $_POST["document"];
$password = sha1(md5($_POST["password"]));

$sql = "SELECT * FROM users WHERE document = '".$document."' ";
$resultado = mysqli_query($con, $sql);

if ($resultado == false || mysqli_num_rows($resultado) === 0) {
	$arrayJson["success"] = '0';
	$arrayJson["message"] = 'Datos no encontrados, intente nuevamente.';
} else {
	$reg = mysqli_fetch_array($resultado);

		if($reg['password'] != $password){
			$arrayJson["success"] = "0";
			$arrayJson["message"] = "Contraseña incorrecta, intente nuevamente.";
		}else if($reg['state'] == "0"){
			$arrayJson["success"] = "0";
			$arrayJson["message"] = "La cuenta esta inactiva";
		}else{

			$sql_key = "SELECT * FROM secret_key;";
			$key_result = mysqli_query($con, $sql_key);
			$key = mysqli_fetch_array($key_result);
			// Generar JWT
			$secret_key = $key["key"]; // Clave secreta para firmar el JWT
			$issuer_claim = "uds_app"; // Emisor del JWT
			$audience_claim = "imc-st.com/uds/"; // Audiencia del JWT
			$issuedat_claim = time(); // Tiempo de emisión del JWT
			$expire_claim = $issuedat_claim + 3600; // Tiempo de expiración del JWT en 1 hora
	
			$token = array(
				"iss" => $issuer_claim,
				"aud" => $audience_claim,
				"iat" => $issuedat_claim,
				"exp" => $expire_claim,
				"data" => array(
					"id_user" => $reg["id_user"],
					"document" => $reg["document"],
					"name" => $reg["name"],
					"lastname" => $reg["lastname"],
					"phone" => $reg["phone"],
					"email" => $reg["email"],
					"id_rol" => $reg["id_rol"],
					"state" => $reg["state"],
					"addAt" => $reg["addAt"]
				)
			);
	
			try {
				$jwt = JWT::encode($token, $secret_key);
				$arrayJson["token"] = $jwt;
				$arrayJson["expiresAt"] = $expire_claim;
				$arrayJson["success"] = '1';
				$arrayJson["message"] = "Usuario encontrado";
				$arrayJson["encontradas"] = mysqli_num_rows($resultado);
				// $arrayJson["result"] = [$token["data"]];
			} catch (Exception $e) {
				$arrayJson["success"] = '0';
				$arrayJson["message"] = 'Error al generar el token: ' . $e->getMessage();
			}
		}
}
	
echo json_encode($arrayJson, JSON_FORCE_OBJECT);

// Cerrar la conexión a la base de datos
mysqli_close($con);