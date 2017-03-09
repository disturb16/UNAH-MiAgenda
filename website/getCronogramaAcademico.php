<?php

	include("connection.php");

	$mes = date("n"); 

	$qry = mysqli_query($conn, " SELECT c.fechaCalendarioID, c.dateTitle, c.tipoFechaID, c.dateInCalendar, t.tipoFecha_description, c.description
								FROM CalendarioAcademico c
								INNER JOIN tipoFechaCalendarioAcademico t on t.tipoFechaID = c.tipoFechaID
								WHERE c.month >= '$mes' 
								ORDER BY dateInCalendar LIMIT 0, 5")
							    or die(mysqli_error($conn));

	$data = '{"Fechas":[{"fechaID":"none","titulo":"dummy","tipoFechaCalendario":"none"}';

	if (!$qry){
		echo "Error";}
	else{
			while($fechaData = mysqli_fetch_array($qry)){

				$id = $fechaData['fechaCalendarioID'];
				$titulo = utf8_encode($fechaData['dateTitle']);
				$tipoFecha = $fechaData['tipoFechaID'];
				$fecha = new dateTime($fechaData['dateInCalendar']);
				$stringFecha = $fecha->format("d/m/Y");
				$tipoFecha = utf8_encode($fechaData["tipoFecha_description"]);
				$descripcion = utf8_encode($fechaData["description"]);
				$data .= ",{'fechaID':'$id','titulo':'$titulo','tipoFechaCalendario':'$tipoFecha', 'fecha':'$stringFecha','descripcion':'$descripcion'}";
			}
				$data .= "]}";
				
			echo $data;
		}
	mysqli_close($conn);
	
?>