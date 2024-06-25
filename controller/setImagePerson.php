<?php

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require __DIR__ . '../../../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

include '../config/config.php';

$document = $_POST['document'];
$type = $_POST["type"];
$url_base = "";

if(verifyToken($con)){

  switch($type){
    case "Estudiante":
      $url_base = '../img/carnet/estudiantes/';
    break;

    case "Funcionario":
      $url_base = '../img/carnet/administrativos/';
    break;
    case "Docente":
      $url_base = '../img/carnet/docentes/';
    break;
    case "Egresado":
      $url_base = '../img/carnet/egresados/';
    break;
  }
  // $type == "Estudiante"? $url_base = '../img/carnet/': ($type == "Funcionario"? $url_base = '../img/carnet/administrativos/' : $url_base = '../img/carnet/docentes/');

  if (isset($_POST['imagen'])) {
    $datos = base64_decode(
      preg_replace('/^[^,]*,/', '', $_POST['imagen'])
    );
    if(file_put_contents($url_base.$document.'.png', $datos)){
      $arrayJson['success'] = '1';
      $arrayJson["message"] = 'La foto se guardo con exito.';
    }else{
      $arrayJson["success"] = '0';
      $arrayJson["message"] = 'Foto no guardada, intente nuevamente.';
    }
      
  }else{
  $arrayJson["success"] = '0';
  $arrayJson["message"] = 'Foto no cargada, intente nuevamente.';
  }

}

echo json_encode($arrayJson,JSON_FORCE_OBJECT);

function verifyToken($con){
        // Obtener el token del header de la solicitud
    $headers = apache_request_headers();
    if (isset($headers['Authorization'])) {
        $authHeader = $headers['Authorization'];
        list($jwt) = sscanf($authHeader, 'Bearer %s');

        if ($jwt) {
            $decoded = verifyJWT($jwt, $con);
            if ($decoded) {
                return true;
            } else {
                // Token no válido
                http_response_code(401);
                $arrayJson['success'] = '0';
                $arrayJson['message'] = 'Acceso denegado.';
                echo json_encode($arrayJson,JSON_FORCE_OBJECT);
                return false;
            }
        } else {
            http_response_code(401);
            $arrayJson['success'] = '0';
            $arrayJson['message'] = 'Acceso denegado.';
            echo json_encode($arrayJson,JSON_FORCE_OBJECT);
            return false;
        }
    } else {
        // No se encontró el header Authorization
        http_response_code(401);
        $arrayJson['success'] = '0';
        $arrayJson['message'] = 'Acceso denegado.';
        echo json_encode($arrayJson,JSON_FORCE_OBJECT);
        return false;
    }
}

function verifyJWT($token, $con) {
    $sql_key = "SELECT * FROM secret_key;";
    $key_result = mysqli_query($con, $sql_key);
    $key = mysqli_fetch_array($key_result);
    // Generar JWT
    $secret_key = $key["key"]; // Clave secreta para firmar el JWT

    try {
        $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
        return (array) $decoded; // Devuelve el payload decodificado
    } catch (ExpiredException $e) {
        http_response_code(401);
        $arrayJson['success'] = '0';
        $arrayJson['message'] = 'Token expirado';
        echo json_encode($arrayJson,JSON_FORCE_OBJECT);
        exit();
    } catch (Exception $e) {
        http_response_code(401);
        $arrayJson['success'] = '0';
        $arrayJson['message'] = 'Token no válido.';
        echo json_encode($arrayJson,JSON_FORCE_OBJECT);
        exit();
    }
}