<?php
	
	include("connection.php");
	$s = md5(mysqli_real_escape_string($conn,"1234"));
	echo $s;

?>