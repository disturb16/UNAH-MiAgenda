<?php
include("connection.php");

$queryUser = mysqli_query($conn,"SELECT m.materia_name, s.startHour, f.seccion, HOUR( NOW( ) ) 
									FROM forma_003 f
									INNER JOIN secciones s ON f.seccion = s.seccion
									INNER JOIN materias m ON m.materiaID = s.materiaID
									WHERE (
									(
									startHour > HOUR( NOW( ) ) -1
									)
									AND (
									userID =1
									)
									)
									AND (
									f.formaStatus =1
									)
									ORDER BY startHour DESC ")  or die(mysqli_error());

$count = mysqli_num_rows($queryUser);

$data = "{'titulo':'','hora':'','seccion':''}";

if (!$queryUser){
	echo "Error";}
else{
		while($nextClass = mysqli_fetch_array($queryUser)){
			
			$titulo = utf8_encode($nextClass['materia_name']);
			$inicio = utf8_encode($nextClass['startHour']);
			$seccion = utf8_encode($nextClass['seccion']);
			$data = "{'titulo':'$titulo','hora':'$inicio','seccion':'$seccion'}";
		}
			
		echo $data;
			}
mysqli_close($conn);
?>