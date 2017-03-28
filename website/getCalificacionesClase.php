<?php

	$json = file_get_contents('php://input');
	$obj = json_decode($json);

	include("connection.php");

	$userID = mysqli_real_escape_string($conn,$obj->{'userID'});
	$seccion = mysqli_real_escape_string($conn,$obj->{'seccion'});

		$cuentaArray = mysqli_fetch_array($qryCuenta);
		$cuenta = $cuentaArray["noCuenta"];
		$qry = mysqli_query($conn, " SELECT c.puntajeCalificacion
									 		,c.periodoAcademicoID
									   FROM calificaciones c
									  WHERE c.usuarioID =  '$userID'
										AND c.seccionID =  '$seccion'
									  GROUP BY c.periodoAcademicoID");


	if (!$qry){
		echo mysqli_error($conn);
		return;
	}
			
	$data = '{"Scores":[{"fechaParcial":"dummy","score":"none"}';

	while ($scoreData = mysqli_fetch_array($qry)) {
		$fechaParcial = $scoreData["periodoAcademicoID"];
		$score = $scoreData["puntajeCalificacion"];

		$data .= ",{'fechaParcial':'$fechaParcial','score':'$score'}";
	}

	$data .= "]}";
	echo $data;
		


	mysqli_close($conn);
?>