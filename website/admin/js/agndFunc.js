function getSecciones(){

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
			});
		}

		function getSolicitudesCuenta(){

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
			});
		}

		function getNoticias(){

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
			});
		}

		function getAsignaturas(){

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
			});
		}

		function getSolicitudesSeccion(){

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
			});
		}