<?php

	include_once("../../connection.php");
	
	$seccionId = mysqli_real_escape_string($conn, $_GET["seccionId"]);

	$qryNuevoParcial = mysqli_query($conn, "SELECT ifnull(MAX(parcial), 0) as nParcial
											  from seccion_parcial 
											 where seccionId = '$seccionId' ");


	if(!$qryNuevoParcial){
		echo "Hubo un error al obtener el parcial actual".$mysqli_error($conn);
		mysql_close($conn);
	}
	//sumar en uno al parcial actual
	$data = mysqli_fetch_array($qryNuevoParcial);
	$nuevoParcial = ++$data["nParcial"]; 
		
	$qryAddParcial = mysqli_query($conn, "INSERT into seccion_parcial(seccionID, parcial, fechaCreo, tipoEstadoId)
													  VALUES('$seccionId', '$nuevoParcial', now(), 1)");

	if (!$qryAddParcial){
		echo "Error al agregar parcial...:"."  ".mysqli_error($conn);
	}
	else
		echo "Parcial Agregado";

	mysqli_close($conn);

?>