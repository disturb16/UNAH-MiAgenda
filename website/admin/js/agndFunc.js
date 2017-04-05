function getSecciones(){

	$(".progress").css("display", "block");

			$.ajax({
			    type: "GET",
			    url: "funcionesPHP/secciones.php",
			    datatype: 'html'
			}).done(function( response ) {
			    var node = document.getElementById("secciones");
			    while (node.firstChild){
			        node.removeChild( node.firstChild );
			    }
			    $("#secciones").append(response);
			    $(".progress").css("display", "none");
			});
		}

		function getSolicitudesCuenta(){

			$(".progress").css("display", "block");

			$.ajax({
			    type: "GET",
			    url: "funcionesPHP/solicitudesCuenta.php",
			    datatype: 'html'
			}).done(function( response ) {
			    var node = document.getElementById("solicitudes");
			    while (node.firstChild){
			        node.removeChild( node.firstChild );
			    }
			    $("#solicitudes").append(response);
			    $(".progress").css("display", "none");
			});
		}

		function getNoticias(){

			$(".progress").css("display", "block");

			$.ajax({
			    type: "GET",
			    url: "funcionesPHP/noticias.php",
			    datatype: 'html'
			}).done(function( response ) {
			    var node = document.getElementById("noticias");
			    while (node.firstChild){
			        node.removeChild( node.firstChild );
			    }
			    $("#noticias").append(response);
			    $(".progress").css("display", "none");
			});
		}

		function getAsignaturas(){

			$(".progress").css("display", "block");

			$.ajax({
			    type: "GET",
			    url: "funcionesPHP/getAsignaturas.php",
			    datatype: 'html'
			}).done(function( response ) {
			    var node = document.getElementById("asignaturas");
			    while (node.firstChild){
			        node.removeChild( node.firstChild );
			    }
			    $("#asignaturas").append(response);
			    $(".progress").css("display", "none");
			});
		}

		function getSolicitudesSeccion(){

			$(".progress").css("display", "block");

			$.ajax({
			    type: "GET",
			    url: "funcionesPHP/getSolicitudesSeccion.php",
			    datatype: 'html'
			}).done(function( response ) {
			    var node = document.getElementById("tickets");
			    while (node.firstChild){
			        node.removeChild( node.firstChild );
			    }
			    $("#tickets").append(response);
			    $(".progress").css("display", "none");
			});
		}

function getForma(seccionID){

	$(".progress").css("display", "block");

			$.ajax({
			    type: "GET",
			    url: "getForma03.php",
			    data: {seccionId: seccionID},
			    datatype: 'html'
			}).done(function( response ) {
			    var node = document.getElementById("contenido-forma");
			    while (node.firstChild){
			        node.removeChild( node.firstChild );
			    }
			    $("#contenido-forma").append(response);
			    $(".progress").css("display", "none");
			});
		}

function adicionarAlumno(usuario, seccion){

	$(".progress").css("display", "block");

	$.ajax({
			    type: "GET",
			    url: "funcionesPHP/adicionarAlumnoSeccion.php",
			    data: {usuarioId: usuario,
			    	   seccionId: seccion},
			    datatype: 'html'
			}).done(function( response ) {
				
			    alert(response);
			    $('#agregarAlumnos').modal('close');
			    getForma(seccion);

			});
}

function validarSolicitud(cuenta){

	$(".progress").css("display", "block");

	if (!confirm("¿Desea crear cuenta para el usuario "+cuenta+" ?"))
		return;

	$.ajax({
		type: "get",
		data: { 
			noCuenta: cuenta
			},
		url: "funcionesPHP/validarSolicitud.php",
		datatype: 'html'
		}).done(function( response ) {
			
			alert(response);
			getSolicitudesCuenta();		

		});



}