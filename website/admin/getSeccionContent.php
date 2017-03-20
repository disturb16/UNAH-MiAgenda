<!DOCTYPE html>
<?php

$seccion = $_GET["seccion"];
session_start();
	include("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);
?>



<div id='alumnosContainer'>
<div class='headerRow'>
	<h2>Alumnos matriculados</h2>
	<ul>
		<li><h5>No. de Cuenta</h5></li>
		<li><h5>Nombre</h5></li>
	</ul>
</div>


<?php
	$periodoActual = 2;
	$count = 0;
	$fecha = 1;
	$qryAlumnos = mysqli_query($con,"select f.userID, u.cuenta, u.name, s.periodo, s.year
									 from forma_003 f
									 inner join users u on f.userID = u.userID
									 inner join secciones s on f.seccion = s.seccion
								     where (f.seccion = '$seccion' AND f.periodo = '$periodoActual') AND (s.periodo = '$periodoActual' and s.year = '2016')");
	if(!$qryAlumnos)
		echo"Error al cargar lista de alumnos";
	else{
		while($data = mysqli_fetch_array($qryAlumnos)){
			++$count;
			$cuenta = $data["cuenta"];
			$nombre = $data["name"];
			$periodo = $data["periodo"];
			$year = $data["year"];
			?>
				<div class='alumnoRow' >
					<a href='#' class='saveScorePopUp' >
				<?php echo"
				<input type='hidden' id='cuenta$count' value='$cuenta' />
				<input type='hidden' id='periodo$count' value='$periodo' />
				<input type='hidden' id='year$count' value='$year' />
				<input type='hidden' id='seccion$count' value='$seccion' />
				<input type='hidden' id='fecha$count' value='$fecha' />
					<ul id='alumno$count'>
						<li>$cuenta</li>
						<li>$nombre</li>
					</ul>
					</a><hr>
				</div>
			";
		}

	}
?>

</div>