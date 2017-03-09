<?php

	include("connection.php");

	$mes = date("n"); 

	$qry = mysqli_query($conn, " SELECT c.cronogramaAcademicoID
										,c.tituloCronograma
										,c.tituloCronograma
										,now() as dateInCalendar
										,t.descripcion as tipoFechaDescripcion
										,c.description as descripcionCronograma
								FROM cronogramaAcademico c
								INNER JOIN tipoFechaCronograma t 
										on t.tipoFechaCronogramaID = c.tipoFechaCronogramaID
								WHERE c.month >= '$mes' 
								ORDER BY dateInCalendar LIMIT 0, 5")
							    or die(mysqli_error($conn));

	$data = '{"Fechas":[{"fechaID":"none","titulo":"dummy","tipoFechaCalendario":"none"}';

	if (!$qry){
		echo "Error";}
	else{
			while($fechaData = mysqli_fetch_array($qry)){

				$id = $fechaData['cronogramaAcademicoID'];
				$titulo = utf8_encode($fechaData['tituloCronograma']);
				$tipoFecha = $fechaData['tipoFechaCronogramaID'];
				$fecha = new dateTime($fechaData['dateInCalendar']);
				$stringFecha = $fecha->format("d/m/Y");
				$tipoFecha = utf8_encode($fechaData["tipoFechaDescripcion"]);
				$descripcion = utf8_encode($fechaData["descripcionCronograma"]);
				$data .= ",{'fechaID':'$id','titulo':'$titulo','tipoFechaCalendario':'$tipoFecha', 'fecha':'$stringFecha','descripcion':'$descripcion'}";
			}
				$data .= "]}";
				
			echo $data;
		}
	mysqli_close($conn);
	
?>