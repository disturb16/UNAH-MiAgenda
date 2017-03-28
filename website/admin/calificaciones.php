<?php
	
	//Obtener información del usuario en sesion
	session_start();
	include("../connection.php");

	//Verificar si han sido inicializadas las variables de sesion
 	if (!isset($_SESSION['usuarioID']) || ($_SESSION['tipoUsuarioID'] != 3)){
 		mysqli_close($conn);
 		header("Location: login.php");
 		return;
 	}

 	$query = mysqli_query($conn,"SELECT * FROM usuarios WHERE usuarioID = '$_SESSION[usuarioID]' and tipoEstadoID = 1")
							or die(mysqli_error($connn));

	if(!$query){
		mysqli_close($conn);
		echo "<script>alert('Error al obtener información de usuario');</script>";
 		header("Location: login.php");
 		return;
	}

	//guardar en memoria datos de usuario
	$data = mysqli_fetch_array($query);
	$usuarioId = $data["usuarioID"];
	$nombres = $data["nombres"];
	$usuario = $data["userName"];

 ?>


<!DOCTYPE html>

<html>

<head>

	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">
	<?php echo "<title>Unah Mi Agenda - Calificaciones"." ".$usuario." </title>"; ?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<meta charset="utf-8"><!-- scripts -->
	<!-- <link href="uploadScoreStyle.css" rel="stylesheet" media="all"/> -->
	<link rel="stylesheet" href="dist/magnific-popup.css">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>	

	<style type="text/css">
	  	body {
	     display: flex;
	     min-height: 100vh;
	     flex-direction: column;
	 }
	 main {
	     flex: 1 0 auto;
	 }
	 </style>

</head>



<?php 
$fechaToday = date("Y-m-d");
$qrySeccion = mysqli_query($conn,"select m.nombreMateria, s.horaInicio, s.seccion, s.habilitarEvaluacion, s.fechaInicio, s.fechaFinal
								 from secciones s
							   	 inner join materias m on s.materiaID = m.materiaID
								 where catedraticoID = '$_SESSION[usuarioID]' ");

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


<main>	
<nav class="nav-extended blue darken-4">
    <div class="nav-wrapper">
      <img src="../imagenes/logo-unah.png" width="200px" height="90px" />
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="#!">Opciones</a></li>
        <li><a href="logOut.php">Cerrar Sesión</a></li>
      </ul>
      <ul class="side-nav" id="mobile-demo">
        <li><a href="#!">Components</a></li>
        <li><a href="logOut.php">Cerrar Sesión</a></li>
      </ul>
    </div>
    <div class="nav-content">
      <ul class="tabs tabs-transparent">
        <li class="tab"><a class="active" href="#calificaciones">Calificaciones</a></li>
        <li class="tab"><a href="#mensajes">Mensajes</a></li>
      </ul>
    </div>
  </nav>
  <div id="calificaciones" class="col s12"></div>
  <div id="mensajes" class="col s12"></div>


</main>

<footer class="page-footer blue darken-4">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">UNAH Mi Agenda</h5>
                <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2017 Derechos Reservados
            </div>
          </div>
        </footer>

	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
    <script type="text/javascript" src="functions.js"></script>
	<script src="dist/jquery.magnific-popup.min.js"></script>
	<script src="js/agndFunc.js"></script>
	<script>
		$(document).ready(function() {
			$('.saveScorePopUp').magnificPopup({
				type: 'ajax',
				alignTop:false,
				closeOnContentClick: false
				});

			$(".button-collapse").sideNav();
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
</html>