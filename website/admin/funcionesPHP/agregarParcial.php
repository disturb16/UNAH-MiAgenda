<?php

	include_once("../../connection.php");
	
	$seccionId = mysqli_real_escape_string($conn, $_GET["seccionId"]);

	$qryNuevoParcial = mysqli_query($conn, "SELECT max(parcial) as nParcial
											  from seccion_parcial 
											 where seccionId = '$seccionId' ");



	$nuevoParcial = 2; //prueba
		
	$qryAddParcial = mysqli_query($conn, "INSERT into seccion_parcial(seccionID, parcial, fechaCreo, tipoEstadoId)
													  VALUES('$seccionId', '$nuevoParcial', now(), 1)");

	if (!$qryAddParcial){
		echo "Error al agregar parcial...:"."  ".$seccionId;
	}
	else
		echo "Parcial Agregado";

	mysqli_close($conn);

?>