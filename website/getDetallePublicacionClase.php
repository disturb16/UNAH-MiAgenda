<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $postID = $obj->{'postID'};
include("connection.php");

$query = mysqli_query($conn,"SELECT contenidoPublicacion from publicaciones_asignatura where publicacionAsignaturaID = '$postID'")
						or die(mysqli_error($conn));

$count = mysqli_num_rows($query);


if (!$query){
	echo "Error";
	mysqli_close($conn);
	return;
}


	$content = mysqli_fetch_array($query);
	$contenido = $content["contenidoPublicacion"];
	$data = "{'PostContent':[{'content':'$contenido'}],'PostComments':[{'nombreUsuario':'none','comentario':'none', 'picture':'none'}";
	
	
	$queryComments = mysqli_query($conn,"SELECT c.comentario
											   ,u.nombres
										       ,u.profilePicture
										from comentarios_publicacion c 
										left join usuarios u  
										 	   on c.usuarioID = u.usuarioID
										 where c.publicacionAsignaturaID = '$postID'")
								or die(mysqli_error($conn));
																
	if (!$queryComments){
		echo "No comments";
		mysqli_close($conn);
		return;
	}
		
	while($commentsData = mysqli_fetch_array($queryComments)){
		$nombre = $commentsData['nombres'];
		$comment = $commentsData['comentario'];
		$picture = "https://unahmiagenda.000webhostapp.com/imagenes/perfil_pictures/".$commentsData["profilePicture"];
			
		$data .= ",{'nombreUsuario':'$nombre','comentario':'$comment', 'picture':'$picture'}";
	}
	
	$data.="]}";
	echo $data;
	
	mysqli_close($conn);

?>