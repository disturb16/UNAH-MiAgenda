<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

$cuenta = $obj->{'cuenta'};
$nombre = $obj->{'nombre'};
$age = $obj->{'age'};
$pwd = md5($obj->{'pwd'});
$email = $obj->{'email'};
$day = $obj->{'_bDay'};
$month = $obj->{'_bMonth'};
$year = $obj->{'_bYear'};

include("connection.php");

$qryUser = mysqli_query($conn, "SELECT noCuenta FROM usuarios WHERE noCuenta = '$cuenta' ");
$row_count = mysqli_num_rows($qryUser);

if ($row_count > 0){
	echo "{'success':'2'}";
}else{
	$qryInsert = mysqli_query($conn,"INSERT INTO cuentaRequest (noCuenta, name, password, birthDay, birthMonth, birthYear, email) 
														 VALUES ('$cuenta','$nombre','$pwd','$day','$month','$year', '$email')");
	if (!$qryInsert){
		echo "{'success':'0'}";
	}
	else{
		echo "{'success':'1'}";
	}
}

mysqli_close($conn);
?>