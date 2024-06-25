<?php
$document = $_POST['document'];
$type = $_POST["type"];
$url_base = "";

$type == "Estudiante"? $url_base = '../img/carnet/': ($type == "Funcionario"? $url_base = '../img/carnet/administrativos/' : $url_base = '../img/carnet/docentes/');

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

echo json_encode($arrayJson,JSON_FORCE_OBJECT);
