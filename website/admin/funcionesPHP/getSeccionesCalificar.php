<?php

	include_once("../../connection.php");

	$seccionId = mysqli_real_escape_string($conn, $_GET["seccionId"]);
	$usuarioId = mysqli_real_escape_string($conn, $_GET["usuarioId"]);
	$periodo = mysqli_real_escape_string($conn, $_GET["periodo"]);


	$parcialesqry = mysqli_query($conn, "SELECT parcial 
									    FROM seccion_parcial 
									   WHERE seccionID = '$seccionId' ");


	$qrySeccion = mysqli_query($conn, "SELECT * 
										  from secciones 
										 WHERE seccionID = '$seccionId' ");
	
	// if (!$query){
	// 	mysql_close($conn);
	// 	echo"no hay asignaturas";
	// 	return;
	// }
?>
<div class="row">
<button class="btn waves-effect waves-light amber lighten-1 black-text" id="btnNuevoParcial" >Agregar parcial</button> 
<button class="btn waves-effect waves-light amber lighten-1 black-text" id="btnSalvar">salvar datos</button>
</div>
<input type="hidden" name="seccion" id="seccionId" value= <?php echo "'$seccionId'"; ?>  >
<input type="hidden" name="periodo" id="periodo" value= <?php echo "'$periodo'"; ?>  >


<ul id="contenedor-calificaciones " class="collapsible popout" data-collapsible="accordion">
<?php 
	
	while ($parciales = mysqli_fetch_array($parcialesqry) ){

			$parcial = $parciales["parcial"];

			$qryCalificacion = mysqli_query($conn,"SELECT forma.usuarioID
									   ,usr.noCuenta
									   ,usr.nombres
								       ,calif.puntajeCalificacion
								       ,case when(calif.parcial is null or calif.parcial = 0) 
								       			then 1  
								       			else calif.parcial
								       	end as parcial
								  FROM forma_003 forma
								 inner join usuarios usr
										 on usr.usuarioID = forma.usuarioID
										and usr.tipoEstadoID = 1 
								  left join calificaciones calif 
										 on calif.usuarioID = forma.usuarioID
										and calif.seccionID = forma.seccionID
										and calif.parcial = '$parcial'
								        and calif.tipoEstadoID = 1
								  WHERE forma.tipoEstadoID = 1
								    and forma.seccionID = '$seccionId'
								    
								   -- and usr.tipoUsuarioID = 2
								   -- and calif.periodoAcademicoID = 1")
						or die(mysqli_error($conn));
	

		?>
		<li>
	      <div class="collapsible-header"><i class="material-icons">list</i>Parcial <?php echo $parcial; ?></div>
	      <div class="collapsible-body">
	      	
	      	<table class='bordered highlight tablaCalif' id="tableCalificaciones">
			<thead>
				<tr>
					<th>No. Cuenta</th>
					<th>Nombre Alumno</th>
					<th>Puntaje Calificación</th>
				</tr>
			</thead>
			<tbody>	
			<?php echo "<input type='hidden' id='parcial$parcial' class='parcial' value='$parcial'>";    ?>			
				<?php


					foreach($qrySeccion as $seccion){


						foreach ($qryCalificacion as $key => $calif) {

							$noCuenta = $calif["noCuenta"];
							$nombres = $calif["nombres"];
							$puntaje = $calif["puntajeCalificacion"];
							echo "
								<tr>
									<td>$noCuenta</td>
									<td>$nombres</td>
									<td contenteditable id='puntaje'>$puntaje</td>
								</tr>";
						}
						

					}
				?>				
			</tbody>
		</table>

	      </div>
	    </li>

<?php	}// end of parciales while

?>
</ul>

<script>
var respuestas = "";	

	$(document).ready(function(){
	    $('.collapsible').collapsible();
	  });


	$("#btnSalvar").click(function (){
		 $(this).prop('disabled', true);
		 
		 
		
		respuestas = "";	


			//Recorrer parciales
			$(".tablaCalif").each(function (tableIndex) {

				var parcialId = $(this).children("tbody").children(".parcial").val();
			    var noCuentas = [];
			    var calificaciones = [];

			    var arrIndex = 0;

			    //recorrer filas de parcial
				$(this).children("tbody").children("tr").each(function (rowIndex) {	
					$("#procesando").css({"display" : "block"});

					var cta, calif;

					//Recorrer columnas
				    $(this).children("td").each(function (columnIndex){
				        switch (columnIndex){

				            case 0:
				            	cta = $(this).text();
				                break;
				            
				            case 2: 
				            	calif = $(this).text();
				                break;
				        }
				    });

			     if (calif != ""){
			     	//se usa este metodo ya que el comando exit o continue no funcionan
			     	noCuentas[arrIndex] = cta;
			     	calificaciones[arrIndex] = calif;
			     	arrIndex++;
			     }

			     

				});	
			    
			    //pasar datos a funcion php para guardarlos
			    $.ajax({
					type: "get",
					data: { seccionId: $("#seccionId").val(),
					    	cuentas: noCuentas,
					    	calificaciones: calificaciones,
					    	periodo: $("#periodo").val(),
					    	parcial: parcialId
					      },
					url: "funcionesPHP/salvarCalificaciones.php",
					datatype: 'text'

				}).done(function( response ) {	

					$("#procesando").css({"display" : "none"});								
					if (response.length > 2)
						alert("Error en parcial:"+parcialId+"\n"+response);

					else
						alert("Notas de parcial "+parcialId+" guardadas exitosamente");		                   		
				});				

			 });//end of tabla
			$("#procesando").css({"display" : "block"});
			$(this).prop('disabled', false);
	});



	$("#btnNuevoParcial").click( function(){

			var aceptar = confirm("¿Desea agregar un nuevo parcial?");

			if (!aceptar)
				return;

			$.ajax({
			    type: "get",
			    data: { seccionId: $("#seccionId").val()
			    	  },
			    url: "funcionesPHP/agregarParcial.php",
			    datatype: 'html'
				}).done(function( response ) {
				    alert(response);
				});

		});


</script>

<?php 
	mysqli_close($conn);
?>