<!DOCTYPE html>
<html>
	<head>	  
	  <title>UNAH Mi Agenda Administracion</title>
	  <!--Import Google Icon Font-->
	   <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
	  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
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
		      <a href="#" class="brand-logo">Logo</a>
		      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		      <ul id="nav-mobile" class="right hide-on-med-and-down">
		        <li><a href="#!">Usuarios</a></li>
		        <li><a href="#!">Reporte Calificaciones</a></li>
		        <li><a href="#!">Cerrar Sesión</a></li>
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
		  <div id="secciones" class="col s12">secciones</div>
		  <div id="noticias" class="col s12">noticias</div>
		  <div id="asignaturas" class="col s12">asignaturas</div>
		  <div id="solicitudes" class="col s12">solicitudes</div>
		  <div id="forma" class="col s12">Forma</div>
		  <div id="tickets" class="col s12">tickets</div>


	</main>
	

	<footer class="page-footer blue darken-4">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">Footer Content</h5>
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
            © 2014 Copyright Text
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
          </div>
        </footer>

	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
    <script src="js/agndFunc.js"></script>
</html>