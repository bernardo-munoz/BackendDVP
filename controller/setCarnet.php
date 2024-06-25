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
        $last_name = $_POST["last_name"];
        $program = $_POST["program"];
        $type = $_POST["type"];
        $state = $_POST["state"];
        $rh = $_POST["rh"];
        
        $sql = "SELECT * FROM carnetizacion WHERE document = '".$document."' ;";
        $resultado = mysqli_query($con, $sql);

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {
        
            $sql = "INSERT INTO carnetizacion VALUES('0','".$document."','".$name."','".$last_name."','".$program."','".$type."','".$state."','".$rh."', (SELECT DATE_SUB(NOW(), INTERVAL 5 HOUR)), (SELECT DATE_SUB(NOW(), INTERVAL 5 HOUR)) );";
            $resultado = mysqli_query($con, $sql);

            if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

                $arrayJson["success"] = '0';
                $arrayJson["message"] = 'Carnet no registrado, intente nuevamente.';

            } else {

                $arrayJson['success'] = '1';
                $arrayJson['message'] = 'Carnet registrado con exito.';
            }
        }
        else{
            $reg = mysqli_fetch_array($resultado);

            $sql = "UPDATE carnetizacion SET name = '".$name."', last_name = '".$last_name."', program = '".$program."', type = '".$type."', rh = '".$rh."', updateAt = (SELECT DATE_SUB(NOW(), INTERVAL 5 HOUR)) WHERE document = '".$document."' ;";
            $resultado = mysqli_query($con, $sql);  

            if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

                $arrayJson["success"] = '0';
                $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.';

            } else {

                $arrayJson['success'] = '1';
                $arrayJson['message'] = 'Carnet actualizado con exito.';
            }
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