<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

$userID = $obj->{'userID'};
$materiaID = $obj->{'materiaID'};
$hora = $obj->{'hora'};

include("connection.php");

$qryInsert = mysqli_query($conn,"INSERT INTO solicitud_seccion (asignaturaID, usuarioID, horaSolicitada, fechaCreo, tipoEstadoID) 
													 VALUES ('$materiaID','$userID','$hora', now(), 5)");

if (!$qryInsert){
	echo "{'success':'0'}";
}
else
	echo "{'success':'1'}";

mysqli_close($conn);
?>