<?php

	$json = file_get_contents('php://input');
	$obj = json_decode($json);

	$user = $obj->{'userID'};
	$periodoActual = 2;

	include("connection.php");

		$queryUser = mysqli_query($conn,"SELECT m.materia_name, s.startHour, f.seccion 
										from forma_003 f
										inner join secciones s on f.seccion = s.seccion
										inner join materias m on m.materiaID = s.materiaID
										WHERE userID = '$user' AND f.formaStatus = 1
										ORDER BY s.startHour")  or die(mysqli_error($conn));
		
		$count = mysqli_num_rows($queryUser);

		if ($count > 0) 
			$type = 1;
		else{
			$queryUser = mysqli_query($conn,"SELECT m.materia_name, s.startHour, s.seccion, c.catedraticoID
											FROM secciones s
											INNER JOIN materias m ON s.materiaID = m.materiaID
											INNER JOIN catedraticos c ON c.userID = '$user'
											WHERE s.catedraticoID = c.catedraticoID
											AND (
											s.period =  '$periodoActual'
											AND s.periodYear =  '2016'
											)
											ORDER BY s.startHour")  or die(mysqli_error());
		
			$count = mysqli_num_rows($queryUser);
			if ($count > 0) 
				$type = 2;		
		}


	$data = '{"Forma03":[{"titulo":"dummy","seccion":"none"}';


	if (!$queryUser){
		echo "Error";}
	else{

		if ($type == 1) {
			while($nextClass = mysqli_fetch_array($queryUser)){
				
				$titulo = utf8_encode($nextClass['materia_name']);
				$seccion = utf8_encode($nextClass['seccion']);
				$horaInicio = $nextClass['startHour'];
				$data .= ",{'titulo':'$titulo','seccion':'$seccion','horaInicio':'$horaInicio'}";
			}
			$data .= "]}";
			echo $data;
		}
		if ($type == 2) {
			while($nextClass = mysqli_fetch_array($queryUser)){
				
				$titulo = utf8_encode($nextClass['materia_name']);
				$seccion = utf8_encode($nextClass['seccion']);
				$horaInicio = $nextClass['startHour'];
				$data .= ",{'titulo':'$titulo','seccion':'$seccion','horaInicio':'$horaInicio'}";
			}
			$data .= "]}";
			echo $data;
		}
			
		}

	mysqli_close($conn);
	
?>