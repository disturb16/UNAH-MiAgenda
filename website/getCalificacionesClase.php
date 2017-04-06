<?php

	$json = file_get_contents('php://input');
	$obj = json_decode($json);

	include("connection.php");

	$userID = mysqli_real_escape_string($conn,$obj->{'userID'});
	$seccion = mysqli_real_escape_string($conn,$obj->{'seccion'});

		$qry = mysqli_query($conn, "SELECT c.puntajeCalificacion 
										   ,c.parcial
									  from calificaciones c
									 where c.usuarioID = '$userID'
									   and c.seccionID = '$seccion'
									   and c.tipoEstadoID = 1
									   and c.periodoAcademicoID = 1
									order by c.parcial");


	if (!$qry){
		echo mysqli_error($conn);
		return;
	}
			
	$data = '{"Scores":[{"fechaParcial":"dummy","score":"none"}';

	while ($scoreData = mysqli_fetch_array($qry)) {
		$parcial = $scoreData["parcial"];
		$score = $scoreData["puntajeCalificacion"];

		$data .= ",{'parcial':'$parcial','score':'$score'}";
	}

	$data .= "]}";
	echo $data;
		


	mysqli_close($conn);
?>