<?php

	include("../../connection.php");

	$seccion = mysqli_real_escape_string($conn,$_POST['seccion']);
	$userID = mysqli_real_escape_string($conn,$_POST['catedraticoID']);
	$titulo = mysqli_real_escape_string($conn,$_POST['titulo']);
	$content = mysqli_real_escape_string($conn,$_POST['content']);
	$tituloClase = mysqli_real_escape_string($conn,$_POST['tituloClase']);

	$catedraticoID = $userID;
	$qryInsert = mysqli_query($conn,"INSERT INTO publicaciones_asignatura (seccionID, usuarioID, contenidoPublicacion, tituloPublicacion, fechaCreo, tipoEstadoID)
									VALUES ('$seccion','$catedraticoID','$content', '$titulo', now(), 1)");

	if (!$qryInsert){
		echo "{'success':'0'}";
		mysqli_close($conn);
		return;
	}


	//send notification
	$headers = array(
	'Authorization: key=AIzaSyDeSjqltnT3m7CbNRSjm17Zu1g1l-TQAwM',
	'Content-Type: application/json'
	);

	$notification = array(
  					'to' => '/topics/'.$seccion,
				    'notification'=> array(
				  		  'body' => $titulo,
				  		  'title' => $tituloClase,
				     ),
				    'data' => array(
				    	'seccion' => $seccion,
				    	'tituloClase' => $tituloClase,
				    	)
	);

   $ch = curl_init();
   curl_setopt( $ch,CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send' );
   curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($notification) );
   curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
   curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
   $result = curl_exec($ch);
   curl_close($ch);
	
   echo "{'success':'1'}";

   mysqli_close($conn);

?>