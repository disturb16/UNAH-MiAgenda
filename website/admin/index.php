<!DOCTYPE html>
<?php
	session_start();
	include("../connection.php");
 	if (isset($_SESSION['userName']) && ($_SESSION['tipoUsuarioID'] == 1)){

		$query = mysqli_query($conn,"SELECT * FROM usuarios WHERE usuarioID = '$_SESSION[usuarioID]'")
							or die(mysqli_error($connn));

		$data = mysqli_fetch_array($query);
		$usuario = $_SESSION["userName"];
	
	}else{
		mysqli_close($connn);
		$usuario = "asdasd";
		header("Location: login.php");
	}

?>
<html>

<head>

	<?php echo "<title>Unah Mi Agenda - Administración". " ".$usuario." </title>"; ?>

	<script src='javascript/jquery-1.11.2.min.js'></script>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

	<meta charset="utf-8">
		<!-- scripts -->

<script type="text/javascript" src="functions.js"></script>

	<script src="dist/jquery.magnific-popup.min.js"></script>

	<link href="indexStyle.css" rel="stylesheet" media="all"/>

	<link rel="stylesheet" href="dist/magnific-popup.css">
	
	
		<script>
	$(document).ready(function() {
			$('.btnS').magnificPopup({
				type: 'ajax',
				alignTop:false,
				closeOnContentClick: false

			});

			$('.btnN').magnificPopup({
				type: 'ajax',
				alignTop:false,
				closeOnContentClick: false

			});

			$('.add').magnificPopup({
				type: 'ajax',
				alignTop:false,
				closeOnContentClick: false
				});

		});	

function redireccionar()
{
	setTimeout("location.href='login.php'");
}
	</script>

</head>



<body>

<!-- nav-menu -->

		<div id="cabecera">	
			<header>
				<nav>
					<h1>Unah Mi Agenda - Administracion</h1>
					<a href='logOut.php' >Cerrar Sesión</a>
				</nav>
			</header>
		</div>


<div class ='all'>
<aside class="Menu">
	<ul>
		<a href='#' onclick='getSecciones()'><li>Secciones</li></a><hr>
		<a href='#' onclick='getNoticias()'><li>Noticias y Eventos</li></a><hr>
		<a href='#' onclick='getSolicitudes()'><li>Solicitudes de cuenta</li></a><hr>
		<a href='#' onclick='getForma()'><li>Forma 03</li></a><hr>
		<a href='#'onclick='getRequestedMaterias()'><li>Tickets</li></a><hr>
		<a href='Report.php'><li>Reporte de calificaciones</li></a>
	</ul>

</aside>
<section class='result'>
	<div id='newSeccion'>
		<a class='btn btnS'  href='editSeccion_popUp.php'>Nueva seccion</a>
	</div>
	<div id='nuevaNoticia'>
		<a class='btn'  href='publicar.php'>Nueva Noticia</a>
	</div>
	<div id='addPopUp'>
		<a class='btn add' id='add' href='addAlumno.php'>Adicionar Alumno</a>
	</div>

	<div id='content'>
	</div>



</section>
</div>

</body>

<footer>

<div>
	<p> 2016 &copy; Unah Mi agenda, All Rights Reserved</p>
</div>

</footer>
<?php mysqli_close($conn); ?>
</html>