<?php
session_start();
include_once("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);

$cuenta = mysqli_real_escape_string($con, $_GET['cuenta']);
$userName = mysqli_real_escape_string($con, $_GET['userName']);
$userType = mysqli_real_escape_string($con, $_GET['userType']);

if ($userType >= $_SESSION['s_priority']){
	$qryUserData = mysqli_query($con, "SELECT * FROM solicitudcuenta WHERE cuenta = '$cuenta'");

	if(!$qryUserData){
		echo mysqli_error($con);
		echo "<br>error al obtener datos de usuario";
	}
	else{
		$data = mysqli_fetch_array($qryUserData);
		$nombre = $data["nombre"];
		$pass = $data["password"];
		$edad = $data["edad"];
		$qryInsert = mysqli_query($con, "INSERT INTO users (cuenta, name, Password, userName, Age, userType)
												VALUES('$cuenta','$nombre','$pass','$userName','$edad','$userType')");

		if (!$qryInsert){
			echo mysqli_error($con);
			echo "<br>Error al insertar usuario ";
		}
		else{

			if ($userType == 3) {
				$qryCatedratico= mysqli_query($con, "SELECT userID from users WHERE cuenta = '$cuenta'");
				$catedratico = mysqli_fetch_array($qryCatedratico);
				$catedraticoID = $catedratico["userID"];

				$qryInsertCatedratico = mysqli_query($con, "INSERT INTO catedraticos (catedraticoID, nombreCatedratico)
													 VALUES('$catedraticoID','$nombre')");
			}

			$qryUpdateSolicitud = mysqli_query($con, "UPDATE solicitudcuenta SET estado = 0 WHERE cuenta = $cuenta");

			if (!$qryUpdateSolicitud){
				echo mysqli_error($con);
				echo "<br>Error al actualizar solicitud";
			}
			else
				echo "success";
		}

	}
}else
	echo "Error";
mysqli_close($con);
?>