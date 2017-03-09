<?php

	include("connection.php");

	$noticiaID = mysqli_real_escape_string($conn,$_GET['noticiaID']);
	$queryNoticia = mysqli_query($conn,"SELECT newContent FROM noticias WHERE newID = '$noticiaID'")
							or die(mysqli_error());
	
	$qry = mysqli_fetch_assoc($queryNoticia);

	$noticia=$qry['newContent'];

	echo "<div >$noticia</<div>";

	mysqli_close($conn);
?>