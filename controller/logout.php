<?php

	require_once '../config/session.php';
	include '../config/config.php';

// -- eliminamos el usuario
/*
if(isset($_SESSION['id_user'])){
	unset($_SESSION['id_user']);
}



if(!isset($_SESSION['id_user']))
	$arrayJson["success"] = "1";
else{
	unset($_SESSION['id_user']);
	$arrayJson["success"] = "1";
}

session_destroy();*/

	$session = new Session();

	$sql = "UPDATE session SET active = 0 WHERE idsession = '".$session->getSession()."'";
    $resultado = mysqli_query($con, $sql);

	$session->closeSession();

	if(!$session->getSessionStatus())
		$arrayJson["success"] = "1";
	else{
		$arrayJson["success"] = "0";
	}

	echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>