<?php
	$json = file_get_contents('php://input');
	$obj = json_decode($json);

	include("connection.php");


	$user = mysqli_real_escape_string($conn,$obj->{'user'});
	$pwd = md5(mysqli_real_escape_string($conn,$obj->{'pass'})); //mysqli_real_escape_string($conn,$obj->{'pass'})

	$queryUser = mysqli_query($conn,"SELECT * 
									   FROM usuarios
									  WHERE noCuenta = '$user' 
									  	AND pass = '$pwd'")
				 or die(mysqli_error($conn));

	if (!$queryUser){
		echo "{'errCod': '0'
			 	,'nombre': '--'
			 	,'usuarioID':'-1'
			 	,'tipoUsuarioID':'-1'
			 	 }";

		mysqli_close($conn);
		return;
	}


	$data = mysqli_fetch_array($queryUser);

	//var_dump($queryUser);

	// echo $pwd;

	// echo $data["nombres"];
	// echo $data["usuarioID"];
	// echo $data["tipoUsuarioID"];

	$nombre = $data["nombres"];
	$usuarioID = $data["usuarioID"];
	$tipoUsuarioID = $data["tipoUsuarioID"];


	echo "{'errCod': '1'
			 	,'nombre': '$nombre'
			 	,'usuarioID':'$usuarioID'
			 	,'tipoUsuarioID':'$tipoUsuarioID'
			 	 }";

	// $userData = mysqli_fetch_array($queryUser);
	// 	echo json_encode($userData); 

	mysqli_close($conn);
?>

