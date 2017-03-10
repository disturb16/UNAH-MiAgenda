<?php

	include("connection.php");

	$noticiaID = mysqli_real_escape_string($conn,$_GET['noticiaID']);
	$queryNoticia = mysqli_query($conn,"SELECT contenidoNoticia FROM noticias WHERE noticiaID = '$noticiaID'")
							or die(mysqli_error($conn));
	
	$qry = mysqli_fetch_assoc($queryNoticia);

	$noticia=$qry['contenidoNoticia'];

	echo "<div>$noticia</<div>";

	mysqli_close($conn);
?>