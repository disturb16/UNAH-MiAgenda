<?php
$_host = "mysql1.000webhost.com";
$_db = "a6603559_agenda";
$_user = "a6603559_admin";
$_pass = "Alchemist2";

$conn = mysqli_connect($_host, $_user, $_pass, $_db);

	if (!$conn){
		echo "<script>console.log(".mysqli_connect_error().")</script>" ;
	}
	
?>