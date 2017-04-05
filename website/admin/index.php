
<?php
	
	//Obtener información del usuario en sesion
	session_start();
	include("../connection.php");

	//Verificar si han sido inicializadas las variables de sesion
 	if (!isset($_SESSION['usuarioID']) || ($_SESSION['tipoUsuarioID'] != 1)){
 		mysqli_close($conn);
 		header("Location: login.php");
 		return;
 	}

 	$query = mysqli_query($conn,"SELECT * FROM usuarios WHERE usuarioID = '$_SESSION[usuarioID]'")
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

	$qrySecciones = mysqli_query($conn, "SELECT 
										       sec.seccionID
										      ,sec.seccion
										      ,asig.descripcion as asignatura
										      ,sec.periodoAcademicoID
										 FROM secciones sec
										 inner join asignaturas asig
												 on asig.asignaturaID = sec.asignaturaID
												and asig.tipoEstadoID = 1
										WHERE 1=1
										  and sec.tipoEstadoID = 1 
										  -- and  sec.periodoAcademicoID = 1");

	if (!$qrySecciones){
		echo mysqli_error($conn);
	}

 ?>

<!DOCTYPE html>
<html>
	<head>	  
	  <title>UNAH Mi Agenda Administracion</title>
	  <!--Import Google Icon Font-->
	  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">
	  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	  <link rel="stylesheet" href="estilos/miagndCss.css">
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

	<main>
		<nav class="nav-extended blue darken-4">
		    <div class="nav-wrapper">
		      <img src="../imagenes/logo-unah.png" width="200px" height="90px" />
		      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		      <ul id="nav-mobile" class="right hide-on-med-and-down">
		        <li><a href="#!">Usuarios</a></li>
		        <li><a href="#!">Reporte Calificaciones</a></li>
		        <li><a href="logOut.php">Cerrar Sesión</a></li>
		      </ul>
		      <ul class="side-nav" id="mobile-demo">
		        <li><a href="sass.html">Sass</a></li>
		        <li><a href="badges.html">Components</a></li>
		        <li><a href="collapsible.html">JavaScript</a></li>
		      </ul>
		    </div>
		    <div class="nav-content">
		      <ul class="tabs tabs-transparent tabs-fixed-width">
		        <li class="tab"><a href="#secciones" onclick="getSecciones()">Secciones</a></li>
		        <li class="tab"><a href="#forma">Forma 03</a></li>
		        <li class="tab"><a href="#tickets" onclick="getSolicitudesSeccion()">Tickets</a></li>
		        <li class="tab"><a href="#asignaturas" onclick="getAsignaturas()">Asignaturas</a></li>
		        <li class="tab"><a href="#noticias" onclick="getNoticias()">Noticias y Eventos</a></li>
				<li class="tab"><a href="#solicitudes" onclick="getSolicitudesCuenta()">Solicitudes Cuenta</a></li>		        		    
		      </ul>
		    </div>
		  </nav>

		  <!-- Barra de carga -->
		  <div class="progress">
		      <div class="indeterminate" style="width: 70%"></div>
		  </div>
		        
		  <div id="secciones" class="col s12"></div>
		  <div id="noticias" class="col s12"></div>
		  <div id="asignaturas" class="col s12"></div>
		  <div id="solicitudes" class="col s10"></div>
		  <div id="forma" class="col s12">
		  	<div class="row">
			  	<div class="input-field col s5">
				    <select class="secciones-forma" id="secciones">
				      <option value="" disabled selected>Elija una sección</option>
				      <?php

				      	while($secciones = mysqli_fetch_array($qrySecciones)){
				      		$id = $secciones["seccionID"];
				      		$seccion = $secciones["seccion"];
				      		$asignatura = $secciones["asignatura"];
				      		echo "<option value='$id' class='optSeccion'>$seccion - $asignatura</option>";
				      	}

				      ?>
				    </select>
				</div>
				<div class="row" id="contenido-forma"></div>
		    </div>

		  </div>
		  <div id="tickets" class="col s12"></div>


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
    <script>

    	$(document).ready(function () {
    		$('.modal').modal();
    		$('select').material_select();	
    		$(".button-collapse").sideNav();
    	});
    	

		$(".secciones-forma").change(function(){
			
			getForma($(this).val());
			$(this).material_select();

		});
    </script>
    <script src="js/agndFunc.js"></script>
</html>


<?php
	mysqli_close($conn);
?>