<?php
include_once("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);

	if (!$con)
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	else{

		$cuenta = mysqli_real_escape_string($con, $_GET['cuenta']);
		$seccion = mysqli_real_escape_string($con, $_GET['seccion']);
		$getAlumno = mysqli_query($con,"SELECT userID FROM users WHERE cuenta = '$cuenta'");

		if (!$getAlumno)
			echo "Error al obtener alumno";

		else{
			$userData = mysqli_fetch_array($getAlumno);
			$userID = $userData["userID"];

			$getSeccionToAdd = mysqli_query($con, "select s.horaInicio,s.horaFinal,s.edificio, 
												   s.aula, m.nombreMateria as asignatura, s.periodo, s.year
												   from secciones s
												   inner join materias m on s.materiaID = m.materiaID
												   where s.seccion = '$seccion' and (s.periodo = '2' and s.year = '2016')");

			if (!$getSeccionToAdd)
				echo "Error al obtener seccion a matricular";
			else{
				$seccionData = mysqli_fetch_array($getSeccionToAdd);

				$horaInicio = $seccionData["horaInicio"];
				$horaFinal = $seccionData["horaFinal"];
				$edificio = $seccionData["edificio"];
				$aula = $seccionData["aula"];
				$asignatura = $seccionData["asignatura"];
				$periodo = $seccionData["periodo"];
				$year = $seccionData["year"];

				$qryInsertToForma = mysqli_query($con, "INSERT INTO forma_003 (userID, periodo, seccion)
																	VALUES('$userID','$periodo','$seccion')");

				if (!$qryInsertToForma){
					echo mysqli_error($con);
					echo "Error al insertar registro";
				}
				else
					echo "success";
			}
		}

	}
	mysqli_close($con);
?>