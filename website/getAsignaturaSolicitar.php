<?php

	include("connection.php");

	$queryAsignatura = mysqli_query($conn,"SELECT asignaturaID
									        ,descripcion 
									   FROM asignaturas")
							or die(mysqli_error($conn));

	$data = '{"Asignaturas":[{"asignaturaID":"none","descripcion":"dummy"}';


	if (!$queryAsignatura){
		echo "Error";
		mysqli_close($conn);
		return;
	}

	
	while($notiData = mysqli_fetch_array($queryAsignatura)){

		$id = $notiData['asignaturaID'];
		$nombreMateria = utf8_encode($notiData['descripcion']);
		$data .= ",{'asignaturaID':'$id','descripcion':'$nombreMateria'}";
	}
	$data .= "]}";
				
	echo $data;
			
	mysqli_close($conn);

?>