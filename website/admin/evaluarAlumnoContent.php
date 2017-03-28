<!DOCTYPE html>
<?php

$seccion = $_GET["seccion"];
session_start();
	include("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);
?>

<div id='alumnosContainer'>
<div class='headerRow'>
	<h2>Alumnos por Evaluar</h2>
	<ul>
		<li><h3>No. de Cuenta</h3></li>
		<li><h3>Nombre</h3></li>
	</ul>
</div>


<?php
	$count = 0;
	$fecha= date("Y/n/d ");
	$qryAlumnos = mysqli_query($con,"select f.userID, u.cuenta, u.name, s.periodo, s.year
									 from forma_003 f
									 inner join users u on f.userID = u.userID
									 inner join secciones s on f.seccion = s.seccion
								     where f.seccion = '$seccion' AND f.evaluado = '0' ");
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
					<a href='#' class='saveScorePopUp' onclick='evaluar(<?php echo $count ?>)'>
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
<div id='asignarNota'></div>
<!-- Contenedor de alumnos evaluados -->
<div id='alumnosEvaluados'>
	<div class='headerRow headerRowEvaluado'>
		<h2>Alumnos Evaluados</h2>
		<ul>
			<li><h3>No. de Cuenta</h3></li>
			<li><h3>Nombre</h3></li>
			<li><h3>Calificación</h3></li>
		</ul>
	</div>
	<?php
	$fecha = 1;
	$qryAlumnos = mysqli_query($con,"select f.userID, u.cuenta, u.name, s.periodo, s.year, sc.score, sc.fechaParcial
									 from forma_003 f
									 inner join users u on f.userID = u.userID
									 inner join secciones s on f.seccion = s.seccion
									 inner join scores sc on (sc.seccionEvaluada = f.seccion and sc.cuenta = u.cuenta)
								     where f.seccion = '$seccion' AND f.evaluado = '1' ORDER BY sc.fechaParcial");
	if(!$qryAlumnos)
		echo"Error al cargar lista de alumnos";
	else{
		while($data = mysqli_fetch_array($qryAlumnos)){
			$cuenta = $data["cuenta"];
			$nombre = $data["name"];
			$periodo = $data["periodo"];
			$year = $data["year"];
			$score = $data["score"];
			$parcial = "Parcial ".$data["fechaParcial"];
			echo"
				<div class='alumnoRow alumnoRowEvaluado'>
					<a href='#''>
					<ul >
						<li>$cuenta</li>
						<li>$nombre</li>
						<li>$score ($parcial)</li>
					</ul>
					</a><hr>
				</div>
			";
		}

	}
?>
</div>
