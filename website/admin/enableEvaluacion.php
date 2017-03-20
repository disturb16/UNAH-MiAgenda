<?php
	session_start();
	include_once("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);

	$enable = mysqli_real_escape_string($con, $_GET["enable"]);
	$fechaParcial = mysqli_real_escape_string($con, $_GET["fechaParcial"]);
	$fechaInicio = mysqli_real_escape_string($con, $_GET["fechaInicio"]);
	$fechaFinal = mysqli_real_escape_string($con, $_GET["fechaFinal"]);

 	if (isset($_SESSION['s_priority']) == 1){

 		if ($enable == 1) {
 			$qry = mysqli_query($con, "SELECT fechaParcial from secciones");
 			$qryFechaParcial = mysqli_fetch_array($qry);
 			$ParcialDate = $qryFechaParcial["fechaParcial"];

 			//Validar fechaParcial a ser evaluada
 			if ($fechaParcial > $ParcialDate) {
 				echo "failed";
 			}else{
				$qryEnable = mysqli_query($con, "UPDATE secciones 
					SET habilitarEvaluacion = 1, fechaParcial = '$fechaParcial', fechaInicio='$fechaInicio', fechaFinal='$fechaFinal'
					WHERE periodo = 2");
			 	if (!$qryEnable) {
			 		echo mysqli_error($con);
			 		echo "failed";
			 	}else
			 		$qryUpdateEvaluado = mysqli_query($con, "UPDATE forma_003 SET evaluado = 0 WHERE periodo = 2");
			 		if (!$qryUpdateEvaluado) {
			 			echo "error al actualizar alumno evaluado";
			 		}else
			 			echo "success";
 			}
 		}

 		if ($enable == 0) {
 			$qryDisable = mysqli_query($con, "UPDATE secciones SET habilitarEvaluacion = 0");
	 		if (!$qryDisable) {
	 			echo mysqli_error($con);
	 			echo "failed";
	 		}else
	 			echo "success";
 		}
 		
 	}

mysqli_close($con);
?>