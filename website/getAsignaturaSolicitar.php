<?php

	include("connection.php");

	$queryUser = mysqli_query($conn,"SELECT materiaID, materia_name FROM materias")
							or die(mysqli_error($conn));

	$count = mysqli_num_rows($queryUser);

	$data = '{"Materias":[{"mateiraID":"none","nombreMateria":"dummy"}';

	$dataArray = [];
	$i = 0;

	if (!$queryUser){
		echo "Error";}
	else{
			while($notiData = mysqli_fetch_array($queryUser)){

				$id = $notiData['materiaID'];
				$nombreMateria = utf8_encode($notiData['nombreMateria']);
				$data .= ",{'materiaID':'$id','nombreMateria':'$nombreMateria'}";
			}
				$data .= "]}";
				
			echo $data;
		}
		
	mysqli_close($conn);

?>