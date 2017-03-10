<?php
  /*	$json = file_get_contents('php://input');
	$obj = json_decode($json);

	include("connection.php");
	$con=mysqli_connect("$_host","$_user","$_pass","$_db");
	$imageEncoded = $obj->{"imageEncoded"}
	$userID = $obj->{'userID'};
	//decode image and put it on var
	$image = base64_decode("$imageEncoded");
	//get User info
	$query = mysqli_query($con,"SELECT * FROM users WHERE userID = '$userID' ")
							or die(mysqli_error());

	$data = mysqli_fetch_array($query);
	$usuario = $data['user'];
	$old_path = $data['perfilPicture'];
	$target= $_SERVER['DOCUMENT_ROOT']."/androidTest/imagenes/";
	$new_img_path =$target.$usuario.".jpg";				
	/*
	if(file_put_contents( $new_img_path, $image ) ){
		$insert= mysqli_query ($con,"UPDATE users SET perfilPicture = '$new_img_path' WHERE usrID = '$userID'");
		if($insert){
			//$do = unlink($old_path);
			//echo "<script>alert('Has cambiado tu foto')</script>";
		}else{
			echo "error al cambiar de imagen";
		}
	}

	file_put_contents( $new_img_path, $image );*/


$json = file_get_contents('php://input');
$obj = json_decode($json);    
$imageBase64 = $obj->{"imageEncoded"}
$imageEncoded = explode(',', $imageBase64);
$image = base64_decode($imageEncoded[1]);

$alterName = rand();
$target= $_SERVER['DOCUMENT_ROOT']."/androidTest/imagenes/";
$new_img_path =$target.$alterName.".jpg";                

move_uploaded_file("fsdf", $new_img_path);


?>