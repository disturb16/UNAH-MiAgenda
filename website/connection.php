<?php
$_host = "localhost";
$_db = "miagnd_unah";
$_user = "usr";
$_pass = "Alchemist2";

$conn = mysqli_connect($_host, $_user, $_pass, $_db);

	if (!$conn){
		echo "<script>console.log(".mysqli_connect_error().")</script>" ;
	}
	
?>