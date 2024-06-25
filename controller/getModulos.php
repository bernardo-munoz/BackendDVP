<?php
include '../config/config.php';

$sql = "SELECT id_modulo, r.rol, modulo FROM modulos m left join roles r ON m.rol = r.id_rol";
$resultado = mysqli_query($con, $sql);

if ($resultado == false || mysqli_num_rows($resultado) === 0) {
    $arrayJson["success"] = '0';
    $arrayJson["message"] = 'Modulos no encontrados, intente nuevamente.';
} else {
    $arrayJson["success"] = '1';
    $arrayJson["message"] = 'Información encontrada.';
    $arrayJson["encontradas"] = mysqli_num_rows($resultado);
    // $arrayJson["sql"] = $sql;

    $data = array(); // Crear un array para almacenar los datos

    while ($reg = mysqli_fetch_array($resultado)) {
        $data[] = array(
            "id_modulo" => $reg["id_modulo"],
            "rol" => $reg["rol"],
            "modulo" => $reg["modulo"]
        );
    }

    $arrayJson["result"] = $data; // Asignar el array de datos a "result"
}

echo json_encode($arrayJson, JSON_FORCE_OBJECT);

// Cerrar la conexión a la base de datos
mysqli_close($con);

