<?php

	include("connection.php");

	$queryUser = mysqli_query($conn,"SELECT * FROM eventos ORDER BY eventoID DESC LIMIT 0,5")
							or die(mysqli_error($conn));

	$count = mysqli_num_rows($queryUser);

	$data = '{"Eventos":[{"titulo":"dummy","portada":"none"}';


	if (!$queryUser){
		echo "Error";
		
	}
	else{
			while($notiData = mysqli_fetch_array($queryUser)){

				$id = $notiData['eventoID'];
				$titulo = $notiData['tituloEvento'];
				$img = "http://unahmiagenda.000webhostapp.com/".$notiData['imagenPortada'];
				$data .= ",{'eventoID':'$id','titulo':'$titulo','portada':'$img'}";
			}
				$data .= "]}";
				
			echo $data;
				}
	mysqli_close($conn);

?>