<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

$postID = $obj->{'postID'};
include("connection.php");

$query = mysqli_query($conn,"SELECT postContent from classPosts where postID = '$postID'")
						or die(mysqli_error());

$count = mysqli_num_rows($query);


if (!$query){
	echo "Error";}
else{
	$content = mysqli_fetch_array($query);
	$contenido = $content["postContent"];
	$data = "{'PostContent':[{'content':'$contenido'}],'PostComments':[{'nombreUsuario':'none','comentario':'none', 'picture':'none'}";
	
	
	$queryComments = mysqli_query($conn,"SELECT c.comment, u.name, u.profilePicture
										from postComments c 
										left join usuarios u on c.userID = u.userID
										where c.postID = '$postID'")
								or die(mysqli_error());
																
	if (!$queryComments)
		echo "No comments";
	else{
		while($commentsData = mysqli_fetch_array($queryComments)){
			$nombre = $commentsData['name'];
			$comment = $commentsData['comment'];
			$picture = "http://www.unahmiagenda.site88.net/".$commentsData["profilePicture"];
			
			$data .= ",{'nombreUsuario':'$nombre','comentario':'$comment', 'picture':'$picture'}";
		}
		$data.="]}";
		echo $data;
	}
}
mysqli_close($conn);
?>