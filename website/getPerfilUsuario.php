<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);


include("connection.php");
$con = mysqli_connect($_host,$_user,$_pass,$_db);

$userID = mysqli_real_escape_string($con,$obj->{'userID'});

$qryUser = mysqli_query($con,"SELECT * FROM usuarios WHERE userID = '$userID'");

if (!$qryUser) {
	echo mysqli_error($con);
}else{
	$userData = mysqli_fetch_array($qryUser);
	$name = utf8_encode($userData["name"]);
	$picture = $userData["profilePicture"];
	$userName = $userData["userName"];
	$data = "{'name':'$name','picture':'$picture', 'userName' : '$userName'}";
}

echo $data;

mysqli_close($con);
?>