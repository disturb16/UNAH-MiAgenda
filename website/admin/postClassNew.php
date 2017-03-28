<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

$seccion = $obj->{'seccion'};
$catedraticoID = $obj->{'catedraticoID'};
$titulo = utf8_encode($obj->{'titulo'});
$content = $obj->{'content'};
$fecha= date("Y/n/d ");

//utf-8 parse
/*utf8_encode($titulo);
utf8_encode($content);*/

include("connection.php");
$con = mysqli_connect($_host,$_user,$_pass,$_db);
mysqli_real_escape_string($content);

$qryInsert = mysqli_query($con,"INSERT INTO classpost (seccion,catedraticoID, postContent,postTitle,postDate)
								VALUES ('$seccion','$catedraticoID','$content', '$titulo', '$fecha')");

if (!$qryInsert){
	echo "{'success':'0'}";
}else
	echo "{'success':'1'}";


mysqli_close($con);
?>