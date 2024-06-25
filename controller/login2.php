<?php
session_start();

include '../config/config.php';

$documento = $_POST["documento"];
$password=sha1(md5($_POST["pass"]));

$sql = "SELECT * FROM usuarios WHERE documento = '" . $documento . "';";
$resultado = mysqli_query($con, $sql);

if ($resultado == false || mysqli_num_rows($resultado) === 0) {
    $arrayJson["success"] = '0';
    $arrayJson["message"] = 'Usuario no encontrado, intente nuevamente.';
} else {
    $arrayJson["success"] = '1';
    $arrayJson["message"] = 'Usuario encontrado.';
    $arrayJson["encontradas"] = mysqli_num_rows($resultado);
    // $arrayJson["sql"] = $sql;
	$_SESSION['id_user'] = $reg['documento'];

    $data = array(); // Crear un array para almacenar los datos

    while ($reg = mysqli_fetch_array($resultado)) {
        $data[] = array(
			"id" =>  $reg["id"],
			'documento' =>  $reg['documento'],
			'nombres' =>  $reg['nombres'],
			'apellidos' =>  $reg['apellidos'],
			'telefono' =>  $reg['telefono'],
			'email' =>  $reg['email'],
			'password' =>  $reg['password'],
			'is_active' =>  $reg['is_active'],
			'rol' =>  $reg['rol'],
        );
    }

    $arrayJson["result"] = $data; // Asignar el array de datos a "result"
}

echo json_encode($arrayJson, JSON_FORCE_OBJECT);

// Cerrar la conexión a la base de datos
mysqli_close($con);

	