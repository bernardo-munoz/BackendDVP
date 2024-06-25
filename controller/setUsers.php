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

if(verifyToken($con)){

    $document = $_POST["document"];
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $state = $_POST["state"];
    $id_rol = $_POST["id_rol"];
    $password = sha1(md5($_POST["password"]));

    $sql = "SELECT * FROM users WHERE document = '".$document."'";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
    
        $sql = "INSERT INTO users VALUES('0','".$document."','".$name."','".$lastname."','".$phone."','".$email."','".$password."','".$id_rol."','".$state."', (SELECT DATE_SUB(NOW(), INTERVAL 5 HOUR)) );";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Usuario no registrado, intente nuevamente.';

        } else {

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Usuario registrado con exito.';

            $sql = "SELECT * FROM users WHERE document = '".$document."'";
            $resultado = mysqli_query($con, $sql);
        }
    }
    else{
        $reg = mysqli_fetch_array($resultado);

        if($_POST["password"] != $reg['password'])
            $password = sha1(md5($_POST["password"]));
        else
            $password = $_POST["password"];

        $sql = "UPDATE users SET name = '".$name."', lastname = '".$lastname."', phone = '".$phone."', email = '".$email."', password = '".$password."', state = '".$state."', id_rol = '".$id_rol."' WHERE document = '".$document."' ;";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.';

        } else {
            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Usuario actualizado con exito.';
            $sql = "SELECT * FROM users WHERE document = '".$document."'";
            $resultado = mysqli_query($con, $sql);
        }
    }

    $reg = mysqli_fetch_array($resultado);
    $arrayJson["success"] = '1';
    $arrayJson["message"] = "Usuario encontrado";
    $arrayJson["encontradas"] = mysqli_num_rows($resultado);
    // $arrayJson["sql"] = $sql;

    $data = array(); // Crear un array para almacenar los datos

    $data[] = array(
        "id_user" => $reg["id_user"],
        "document" => $reg["document"],
        "name" => $reg["name"],
        "lastname" => $reg["lastname"],
        "phone" => $reg["phone"],
        "email" => $reg["email"],
        "password" => $reg["password"],
        "id_rol" => $reg["id_rol"],
        "state" => $reg["state"],
        "addAt" => $reg["addAt"]
    );

    $arrayJson["result"] = $data; // Asignar el array de datos a "result"
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
                return false;
            }
        } else {
            http_response_code(401);
            $arrayJson['success'] = '0';
            $arrayJson['message'] = 'Acceso denegado.';
            return false;
        }
    } else {
        // No se encontró el header Authorization
        http_response_code(401);
        $arrayJson['success'] = '0';
        $arrayJson['message'] = 'Acceso denegado.';
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