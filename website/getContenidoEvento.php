<?php
	include("connection.php");

	$eventoID = mysqli_real_escape_string($conn,$_GET['eventoID']);

	$queryNoticia = mysqli_query($conn,"SELECT eventContent FROM eventos WHERE eventID = '$eventoID'")
							or die(mysqli_error($conn));
	
	$qry = mysqli_fetch_assoc($queryNoticia);

	$evento=$qry['eventContent'];

	echo "<div >$evento </<div>";

	mysqli_close($conn);
?>