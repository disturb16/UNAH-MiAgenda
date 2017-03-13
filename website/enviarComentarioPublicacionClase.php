<?php

	$json = file_get_contents('php://input');
	$obj = json_decode($json);

	include("connection.php");

	$postID = mysqli_real_escape_string($conn,$obj->{'postID'});
	$userID = mysqli_real_escape_string($conn,$obj->{'userID'});
	$comment = mysqli_real_escape_string($conn,$obj->{'comment'});


	$qry = mysqli_query($conn,"INSERT INTO comentarios_publicacion (publicacionAsignaturaID, usuarioID, comentario, tipoEstadoID, fechaCreo) 
								 VALUES ('$postID','$userID','$comment', 1, now())")
							or die(mysqli_error($conn));


	if (!$qry){
		echo "false";
		}
	else{
		echo "true";
	}
	mysqli_close($conn);
	
?>