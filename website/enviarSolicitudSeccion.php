<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

$userID = $obj->{'userID'};
$materiaID = $obj->{'materiaID'};
$jornada = $obj->{'jornada'};

include("connection.php");

$periodo = mysqli_fetch_array(mysqli_query($conn, "SELECT periodoAcademicoID from periodoAcademico where tipoEstadoID = 1"));
$periodoID = $periodo["periodoAcademicoID"];

$qryInsert = mysqli_query($conn,"INSERT INTO solicitud_seccion (asignaturaID, usuarioID, jornadaSolicitada, fechaCreo, tipoEstadoID, periodoAcademicoID) 
													 VALUES ('$materiaID','$userID','$jornada', now(), 5, '$periodoID')");

if (!$qryInsert){
	echo "{'success':'0'}";
}
else
	echo "{'success':'1'}";

mysqli_close($conn);
?>