<!DOCTYPE html>
<html>
<head>

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">
	<title>Unah Mi Agenda - Calificaciones </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ URL::to('/') }}/css/app.css">
	<meta charset="utf-8">
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
<nav class="nav-extended blue darken-3">
    <div class="nav-wrapper">
      <img src="{{ URL::to('/') }}/img/logo-unah.png" width="200px" height="90px" />
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="#!">Opciones</a></li>
        <li><a href="logOut.php">Cerrar Sesión</a></li>
      </ul>
      <ul class="side-nav" id="mobile-demo">
        <li><a href="#!">Opciones</a></li>
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
  <div class="progress" id="procesando">
      <div class="indeterminate"></div>
  </div>
  <div id="calificaciones" class="col s12">
  <div class="row">
	  	<div class="input-field col s3">
		    <select class="secciones-calificar" id="secciones">
		      <option value="" disabled selected>Elija una sección</option>
		      		@foreach ($data["secciones"] as $secciones)
		      			<option value='{{$secciones->seccionID}}'>{{$secciones->seccion}} - {{$secciones->asignatura}}</option>
              @endforeach
		    </select>
		</div>
		<br>
  </div>

  <div class="row">
 	<div class="secciones-calificar-contenido col s9 offset-s1" id="calificaciones-contenido"></div>
  </div>

  </div><!-- Fin de calificaciones -->


  <div id="mensajes" class="row col s12">

  	<div class="row">
	  	<div class="input-field col s3">
		    <select class="secciones-mensaje" id="">
		      <option value="-1" disabled selected>Elija una sección</option>
                @foreach ($data["secciones"] as $secciones)
		      		<option value='{{$secciones->seccionID}}'>{{$secciones->seccion}} - {{$secciones->asignatura}}</option>
                @endforeach
		    </select>
		</div>
		<br>
  	</div>

  	<div class="row">
	 	<div class="secciones-mensaje-contenido col s9 offset-s1" id="mensajes-contenido"></div>
	</div>

  </div>

<input type="hidden" name="usuario" id="usuarioId" value="{{$data['dataUsuario']->usuarioID}}" />
<input type="hidden" name="periodo" id="periodo" value= "1">
</main>

<footer class="page-footer blue darken-3">
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
	<script src="{{ URL::to('/') }}/js/agndFunc.js"></script>
	<script>
		$(document).ready(function() {

			$(".button-collapse").sideNav();

			$("#puntaje").keyup(function(){
				var p = document.getElementById("puntaje").value;
				p.replace(/[^0-9\.]+/g, '');

			});
		});
			
		$('select').material_select();

		$(".secciones-calificar").change(function(){

			$.ajax({
		    type: "get",
		    data: { seccionId: $(this).val(),
		    		usuarioId: $("#usuarioId").val(),
		    		periodo: $("#periodo").val() 
		    	  },
		    url: "funcionesPHP/getSeccionesCalificar.php",
		    datatype: 'html'
			}).done(function( response ) {
			    var node = document.getElementById("calificaciones-contenido");
			    while (node.firstChild){
			        node.removeChild( node.firstChild );
			    }
			    $(".secciones-calificar-contenido").append(response);
			});

			$(this).material_select();
		});	

		$(".secciones-mensaje").change(function(){

			$.ajax({
		    type: "get",
		    data: { seccionId: $(this).val()
		    	  },
		    url: "funcionesPHP/getSeccionesPublicacion.php",
		    datatype: 'html'
			}).done(function( response ) {
			    var node = document.getElementById("mensajes-contenido");
			    while (node.firstChild){
			        node.removeChild( node.firstChild );
			    }
			    $(".secciones-mensaje-contenido").append(response);
			});

			$(this).material_select();
		});	    

		</script>

</html>