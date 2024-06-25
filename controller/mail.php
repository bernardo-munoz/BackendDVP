<?php

$to = $_POST["correo"];
$nombre = $_POST["nombre"];

//$to = "soportecampus@unisucre.edu.co";
//$nombre = "Ing. Ismael Meza";

$subject = "Solicitud de registro de empresa";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: noreply@unisucre.edu.co";

$message = "
<html>
<head>
<title>HTML</title>
</head>
<body>
<h3>Saludos ".$nombre.",</h3>
<p>Una nueva empresa se ha registrado, confirma el registro. Revisa el aplicativo <a href='https://servicios.unisucre.edu.co/uds/'>dando click aqui</a> </p>
</body>
</html>";

mail($to, $subject, $message, $headers);


?>