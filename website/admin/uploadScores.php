<!DOCTYPE html>
<?php
session_start();
	include("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);
 if (isset($_SESSION['s_username'])&&($_SESSION['s_priority'] == 3)){
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

	<script src='javascript/jquery-1.11.2.min.js'></script>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

	<meta charset="utf-8">
		<!-- scripts -->

<script type="text/javascript" src="functions.js"></script>

	<script src="dist/jquery.magnific-popup.min.js"></script>

	<link href="uploadScoreStyle.css" rel="stylesheet" media="all"/>

	<link rel="stylesheet" href="dist/magnific-popup.css">

	</script>


		<script>
	$(document).ready(function() {
			$('.saveScorePopUp').magnificPopup({
				type: 'ajax',
				alignTop:false,
				closeOnContentClick: false
				});
			});
		</script>

		<style >
			.btnEmail{
				box-sizing: border-box;
				width: 20%;
				height: 30px;
				padding: 6px;
				background-color: #fff;
				border: 1px solid #4B4A4A;
				border-radius: 0.2em;
				color: #000;
				text-align: center;
				text-decoration: none;
				font-size: 10pt;
				font-family: roboto, calibri, arial;
			}
			.btnEmail:hover{
				cursor: pointer;
				box-shadow: 0 0 1px #7D7E7E;
			}

			.btnEmail:active{
				background: #999;
			}
		</style>


</head>


<body>

<!-- nav-menu -->

		<div id="cabecera">	
			<header>
				<nav>
					<h1>Unah Mi Agenda - Evaluación de alumnos</h1>
					<a href='logOut.php' >Cerrar Sesión</a>
				</nav>
			</header>
		</div>


<div class ='all'>


<div id='content'>
<!-- Contenedor de alumnos pendientes a evaluar -->


<?php 
$fechaToday = date("Y-m-d");
$qrySeccion = mysqli_query($con,"select m.nombreMateria, s.horaInicio, s.seccion, s.habilitarEvaluacion, s.fechaInicio, s.fechaFinal
								 from secciones s
							   	 inner join materias m on s.materiaID = m.materiaID
								 where catedraticoID = '$_SESSION[s_userID]' ");

if(!$qrySeccion)
	$seccion = -1;

else{
	echo "<SELECT name='seccion' id='selectSeccion'";?> onchange="getSeccionEvaluar(1)">
	<?php 
	while ($dataSeccion = mysqli_fetch_array($qrySeccion)) {			

		if (($dataSeccion["habilitarEvaluacion"] == 1) && (($fechaToday >= $dataSeccion["fechaInicio"]) && ($fechaToday <= $dataSeccion["fechaFinal"]))) {
			$seccion = $dataSeccion["seccion"];
			$materia = utf8_encode($dataSeccion["nombreMateria"]);
			echo"<option value='$seccion'>$materia</option>";
		}else
			echo"<option value='-1'>No hay secciones habilitadas</option>";		
	}
	echo "</SELECT> <a href='#' class='btnEmail'><span class='fa fa-envelope'></span> Recibir copia de calificaciones</a><br>";
	echo "<script>getSeccionEvaluar(1);</script> ";

}
?>

</div>

<div id='alumnosEvaluar'></div>

</div>



</body>

<footer>

<div>

	<p> 2016 &copy; Unah Mi agenda, All Rights Reserved</p>
   	<p><span id="contact"><a href='contact.php'>Contáctanos</a></span></p>

</div>

</footer>
</html>