<?php

	$json = file_get_contents('php://input');
	$obj = json_decode($json);

	$user = $obj->{'usuarioID'};
	$periodoActual = 2;

	include("connection.php");

		$queryUser = mysqli_query($conn,"SELECT m.descripcion, s.horaInicio, f.seccionID
										from forma_003 f
										inner join secciones s 
												on f.seccionID = s.seccionID
										inner join asignaturas m 
												on m.asignaturaID = s.asignaturaID
										WHERE f.usuarioID = '$user' 
										  AND f.tipoEstadoID = 1
										ORDER BY s.horaInicio")  or die(mysqli_error($conn));
		
		$count = mysqli_num_rows($queryUser);

		if ($count > 0) 
			$type = 1;
		// else{
		// 	$queryUser = mysqli_query($conn,"SELECT m.materia_name, s.startHour, s.seccion, c.catedraticoID
		// 									FROM secciones s
		// 									INNER JOIN materias m ON s.materiaID = m.materiaID
		// 									INNER JOIN catedraticos c ON c.userID = '$user'
		// 									WHERE s.catedraticoID = c.catedraticoID
		// 									AND (
		// 									s.period =  '$periodoActual'
		// 									AND s.periodYear =  '2016'
		// 									)
		// 									ORDER BY s.startHour")  or die(mysqli_error($conn));
		
		// 	$count = mysqli_num_rows($queryUser);
		// 	if ($count > 0) 
		// 		$type = 2;		
		// }


	$data = '{"Forma03":[{"titulo":"dummy","seccion":"none"}';


	if (!$queryUser){
		echo "Error";
		mysqli_close($conn);
		return;
	}

	while($nextClass = mysqli_fetch_array($queryUser)){
				
		$titulo = utf8_encode($nextClass['descripcion']);
		$seccion = utf8_encode($nextClass['seccionID']);
		$horaInicio = $nextClass['horaInicio'];
		$data .= ",{'titulo':'$titulo','seccion':'$seccion','horaInicio':'$horaInicio'}";
	}
	
	$data .= "]}";
	echo $data;
			

	mysqli_close($conn);
	
?>