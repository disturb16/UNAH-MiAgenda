<?php
	include_once("../../connection.php");

	$descripcion = mysqli_real_escape_string($conn,$_POST["descripcion"]);
	$codigo = mysqli_real_escape_string($conn,$_POST["codigo"]);

	$qrySeccionValida = mysqli_query($conn, "SELECT * 
											   FROM asignaturas
											  WHERE codigoAsignatura = '$codigo'
											  ");

	if (mysqli_num_rows($qrySeccionValida) > 0 ){
		mysqli_close($conn);
		echo "<script>alert('Ya ha sido agregada una asignatura con este codigo')</script>";
		echo "<script>window.history.back();</script>";
		return;
	}
	
	$qryInsert = mysqli_query($conn,"INSERT INTO 
												asignaturas (descripcion, codigoAsignatura, tipoEstadoID, fechaCreo)
											values('$descripcion','$codigo', 1, now() )");
	
	if(!$qryInsert){
		echo mysqli_error($conn);
	}else
		echo "<script>alert('Asignatura añadida')</script>";
	mysqli_close($conn);
 	echo "<script>window.history.back();</script>";
?>