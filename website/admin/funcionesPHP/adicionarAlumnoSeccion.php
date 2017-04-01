<?php
	session_start();
	include_once("../../connection.php");

	$seccionID = mysqli_real_escape_string($conn, $_GET["seccionId"]);
	$usuarioID = mysqli_real_escape_string($conn, $_GET["usuarioId"]);


	$qryAdicionar = mysqli_query($conn, "INSERT into forma_003 (usuarioID, seccionID, tipoEstadoID, fechaCreo)
													VALUES('$usuarioID', '$seccionID', 1, now() )");

	if(!$qryAdicionar)
		echo "Hubo un error al adicionar el alumno";
	else
		echo "Alumno adicionado exitosamente";

	mysqli_close($conn);
?>