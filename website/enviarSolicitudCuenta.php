<?php

	$json = file_get_contents('php://input');
	$obj = json_decode($json);

	$cuenta = $obj->{'cuenta'};
	$nombre = $obj->{'nombre'};
	//$age = $obj->{'age'};
	$pwd = md5($obj->{'pwd'});
	$email = $obj->{'email'};
	$day = $obj->{'_bDay'};
	$month = $obj->{'_bMonth'};
	$year = $obj->{'_bYear'};

	include("connection.php");

	$qryUser = mysqli_query($conn, "SELECT noCuenta 
									  FROM usuarios 
									 WHERE noCuenta = '$cuenta' ");
	$row_count = mysqli_num_rows($qryUser);

	if ($row_count > 0){
		echo "{'success':'2'}";
		mysqli_close($conn);
		return;
	}

	$qrySolicitud = mysqli_query($conn, "SELECT noCuenta 
										   FROM solicitud_cuenta 
										  WHERE noCuenta = '$cuenta' 
										  	AND tipoEstadoID = 5 ");
	$row_count = mysqli_num_rows($qrySolicitud);

	if ($row_count > 0){
		echo "{'success':'3'}";
		mysqli_close($conn);
		return;
	}



	$qryInsert = mysqli_query($conn,"INSERT INTO solicitud_cuenta (noCuenta, nombres, pass, fechaNacimiento, fechaCreo, tipoEstadoID, email) 
														 VALUES ('$cuenta',
														 '$nombre',
														 '$pwd', 
														  cast('$year.$month.$day' as DATE),
														  now(),
														  5, 
														  '$email'
														  )"
							);
	if (!$qryInsert){
		echo "{'success':'0'}";
		mysqli_close($conn);
		return;
	}

	echo "{'success':'1'}";

	mysqli_close($conn);

?>