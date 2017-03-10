<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

include("connection.php");

$postID = mysqli_real_escape_string($conn,$obj->{'postID'});
$userID = mysqli_real_escape_string($conn,$obj->{'userID'});
$comment = mysqli_real_escape_string($conn,$obj->{'comment'});


$qry = mysqli_query($conn,"INSERT INTO postComments (postID, userID, comment) VALUES ('$postID','$userID','$comment')")
						or die(mysqli_error());


if (!$qry){
	echo "false";
	}
else{
	echo "true";
}
mysqli_close($conn);
?>