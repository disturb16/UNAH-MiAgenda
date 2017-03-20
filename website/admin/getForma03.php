<!DOCTYPE html>
<?php
session_start();
	include("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);
 if (isset($_SESSION['s_username'])&&($_SESSION['s_priority'] == 1)){
	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();

	else{
			$query = mysqli_query($con,"SELECT * FROM users WHERE userName = '$_SESSION[s_username]'")
							or die(mysqli_error());
			$data = mysqli_fetch_array($query);
			$usuario = $_SESSION["s_username"];
	}
}else{
	$usuario = "asdasd";
	header("Location: login.php");
	die();
}
?>
<html>

<head>

	<?php echo "<title>Unah Mi Agenda - Administracion"." ".$usuario." </title>"; ?>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta charset="utf-8">

	<link href="uploadScoreStyle.css" rel="stylesheet" media="all"/>

	<link rel="stylesheet" href="dist/magnific-popup.css">

<style>
	#alumnosContainer{
		width:90%;
		margin: 10px auto;
		display: block;
	}
	.alumnoRow{
		width: 90%;
	}

	#alumnosEvaluados{
		display: none;
	}
</style>


</head>


<body>



<div class ='all'>


<div id='content'>
<!-- Contenedor de alumnos pendientes a evaluar -->


<?php 
$qrySeccion = mysqli_query($con,"select m.nombreMateria, s.horaInicio, s.seccion
								 from secciones s
							   	 inner join materias m on s.materiaID = m.materiaID
							   	 WHERE s.periodo = '2' and s.year = '2016'");

if(!$qrySeccion)
	$seccion = -1;

else{
	echo "<SELECT name='seccion' id='selectSeccion'";?> onchange="getSeccionEvaluar(2)">
	<option value='-1'>---Seleciona una Sección---</option>
	<?php 
	while ($dataSeccion = mysqli_fetch_array($qrySeccion)) {
		$seccion = $dataSeccion["seccion"];
		$materia = utf8_encode($dataSeccion["nombreMateria"]);
		echo"<option value='$seccion'>$materia ($seccion)</option>";
	}
	echo "</SELECT><br>";;
}
?>

</div>

<div id='alumnosEvaluar'></div>

</div>



</body>

</html>