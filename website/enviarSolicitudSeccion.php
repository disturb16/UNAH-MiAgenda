<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

$userID = $obj->{'userID'};
$materiaID = $obj->{'materiaID'};
$hora = $obj->{'hora'};
$fecha=date("Y/n/d"); 

include("connection.php");

$qryInsert = mysqli_query($conn,"INSERT INTO materiasrequested (materiaID,userID,hora, dateCreated) 
													 VALUES ('$materiaID','$userID','$hora','$fecha')");

if (!$qryInsert){
	echo "{'success':'0'}";
}
else
	echo "{'success':'1'}";

mysqli_close($conn);
?>