<?php

require __DIR__ . '../../vendor/autoload.php';
use \Firebase\JWT\JWT;

include '../config/config.php'; // Incluir configuración de la base de datos

// Obtiene el token de la solicitud
$token = $_POST['token'];

if (!$token) {
    // Token no proporcionado
    http_response_code(401);
    echo json_encode(array("message" => "Acceso denegado."));
    exit();
}

try {
    // Decodifica el token
    $decoded = JWT::decode($token, $secret_key, array('HS256'));

    // Aquí puedes realizar más validaciones según tus necesidades
    // Por ejemplo, verificar si el token ha expirado
    if ($decoded->exp < time()) {
        http_response_code(401);
        echo json_encode(array("message" => "Token expirado."));
        exit();
    }

    // El token es válido
    // Puedes acceder a los datos del usuario desde $decoded->data
    $user = $decoded->data;

    // Aquí puedes realizar más operaciones según tus necesidades
    // Por ejemplo, verificar permisos o roles

    // Devolver una respuesta exitosa
    http_response_code(200);
    echo json_encode(array("message" => "Token válido.", "data" => $user));
} catch (Exception $e) {
    // Error al decodificar el token (token inválido)
    http_response_code(401);
    echo json_encode(array("message" => "Token inválido.", "error" => $e->getMessage()));
}
