<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

include("connection.php");


$user = mysqli_real_escape_string($conn,$obj->{'user'});
$pwd = md5(mysqli_real_escape_string($conn,$obj->{'pass'}));

$queryUser = mysqli_query($conn,"SELECT * FROM usuarios WHERE noCuenta = '$user' AND password = '$pwd' ")
						or die(mysqli_error());
if (!$queryUser){
	echo "Error";}
else{
$userData = mysqli_fetch_array($queryUser);
	echo json_encode($userData); 
}
mysqli_close($conn);
?>