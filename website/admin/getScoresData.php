<?php
include("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);

	$qry = mysqli_query($con, "select round(sum(score)/count(score)) as score, fecha, fechaParcial
								from scores
								group by fechaParcial
								order by fecha");


	if (!$qry) 
		echo "Error";
	else{

		$info = '{"Scores":[{"cuenta":"dummy","fecha":"dummy"}';
		while ($data = mysqli_fetch_array($qry)) {
			$score = $data["score"];
			$fecha = new dateTime($data["fecha"]);
			$ffecha = $fecha->format("d/m/Y");
			$fechaParcial = $data["fechaParcial"];
			$info .= ',{"score":"'.$score.'","fechaParcial":"'.$fechaParcial.'","fecha":"'.$ffecha.'"}';
		}

		$info .= "]}";

		echo $info;
	}
mysqli_close($con);
?>