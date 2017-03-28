<?php
	include_once("../../connection.php");

	$seccion = mysqli_real_escape_string($conn,$_POST["seccion"]);
	$asignatura = mysqli_real_escape_string($conn,$_POST["asignatura"]);
	$horaI = mysqli_real_escape_string($conn,$_POST["horaInicio"]);
	$horaF = mysqli_real_escape_string($conn,$_POST["horaFin"]);
	$edificio = mysqli_real_escape_string($conn,$_POST["edificio"]);
	$aula = mysqli_real_escape_string($conn,$_POST["aula"]);
	$periodo = mysqli_real_escape_string($conn,$_POST["periodo"]);
	$edificio = mysqli_real_escape_string($conn,$_POST["edificio"]);
	$catedratico = mysqli_real_escape_string($conn,$_POST["catedratico"]);

	$qrySeccionValida = mysqli_query($conn, "SELECT * 
											   FROM secciones
											  WHERE asignaturaID = '$asignatura'
											  	AND usuarioID = '$catedratico' ");

	if (mysqli_num_rows($qrySeccionValida) > 0 ){
		mysqli_close($conn);
		echo "<script>alert('La seccion seleccionada ya está asignada a este catedratico')</script>";
		echo "<script>window.history.back();</script>";
		return;
	}
	
	$qryInsert = mysqli_query($conn,"INSERT INTO 
												secciones (asignaturaID, seccion, horaInicio, horaFin, edificio, salonClase, usuarioID, periodoAcademicoID, tipoEstadoID, fechaCreo)
											values('$asignatura','$seccion','$horaI','$horaF','$edificio','$aula','$catedratico','$periodo', 1, now() )");
	
	if(!$qryInsert){
		echo mysqli_error($conn);
	}else
		echo "<script>alert('Seccion añadida')</script>";
	mysqli_close($conn);
 	echo "<script>window.history.back();</script>";
?>