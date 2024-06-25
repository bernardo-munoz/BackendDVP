<?php

include '../config/config.php';

$placa = $_GET["placa"];

$sourcePath = $_FILES[$placa]['tmp_name']; // Ruta del fichero
$targetPath = "../img/equipos/".$_FILES[$placa]['name']; // Destino de la imagen cargada
move_uploaded_file($sourcePath,$targetPath) ; // Mover el fichero a destino
echo "1";

/*
if (($_FILES["file"]["type"] == "image/pjpeg")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/png")
    || ($_FILES["file"]["type"] == "image/gif")) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], "../images/clientes/".$_FILES['file']['name'])) {
        //more code here...
        echo "../images/clientes/".$_FILES['file']['name'];
    } else {
        echo "0".$_FILES['file']['name'];
    }
} else {
    echo 0;
}
*/