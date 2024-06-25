<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include '../config/config.php';

$documento = $_POST["document"];

//Nos traemos las credenciales de acceso desde la BD
$sql = "SELECT * FROM user_api_sma;";
$resultado = mysqli_query($con, $sql);

if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
   $credential = base64_encode("0:0");
}else{
   $reg = mysqli_fetch_array($resultado);
   $credential = base64_encode($reg["user"].":".$reg["pass"]);
}

$url = "https://sma.unisucre.edu.co/Smaix14/servlet/Adm/PersonalData?event=LISPRS&company=UDS";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//Almacendar las credenciales base de datos Base64(usuario:clave)
//$credential = base64_encode("****:****");


$headers = array(
   "Accept: application/json",
   "Authorization: Basic {$credential}",
   "Content-Type: application/json"
);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = '{"document" : "'.$documento.'" }';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

$resp = curl_exec($curl);
curl_close($curl);

echo $resp;

/*
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FAILONERROR, true);
$resp = curl_exec($curl);

if (curl_errno($curl)) {
    $error_msg = "Error: " . curl_error($curl);
}

curl_close($curl);

if (isset($error_msg))
    echo $error_msg;
else
   echo $resp;
*/
   
?>