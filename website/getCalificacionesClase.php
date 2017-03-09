<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

include("connection.php");

$userID = mysqli_real_escape_string($conn,$obj->{'userID'});
$seccion = mysqli_real_escape_string($conn,$obj->{'seccion'});

$qryCuenta = mysqli_query($conn, "SELECT noCuenta FROM usuarios WHERE userID = '$userID' ");
if (!$qryCuenta) {
	echo mysql_error($conn);
}else{
	$cuentaArray = mysqli_fetch_array($qryCuenta);
	$cuenta = $cuentaArray["noCuenta"];
	$qry = mysqli_query($conn, " SELECT score, evaluationPeriod
								FROM scores
								WHERE cuenta =  '$cuenta'
								AND seccion =  '$seccion'
								GROUP BY evaluationPeriod");


	if (!$qry)
		echo mysqli_error($conn);
	else{
		$data = '{"Scores":[{"fechaParcial":"dummy","score":"none"}';

		while ($scoreData = mysqli_fetch_array($qry)) {
			$fechaParcial = $scoreData["evaluationPeriod"];
			$score = $scoreData["score"];

			$data .= ",{'fechaParcial':'$fechaParcial','score':'$score'}";
		}
		$data .= "]}";
		echo $data;
	}
}


mysqli_close($conn);
?>