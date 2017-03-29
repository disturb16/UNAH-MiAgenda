<?php

	include_once("../../connection.php");


	$seccionId = mysqli_real_escape_string($conn, $_GET["seccionId"]);
	$usuarioId = mysqli_real_escape_string($conn, $_GET["usuarioId"]);
	$periodo = mysqli_real_escape_string($conn, $_GET["periodo"]);

	$query = mysqli_query($conn,"SELECT forma.usuarioID
									   ,usr.noCuenta
									   ,usr.nombres
								       ,calif.puntajeCalificacion
								       -- ,case when(calif.parcial is null or calif.parcial = 0) 
								       -- 			then 1  
								       -- 			else calif.parcial
								       	-- end as parcial
								  FROM forma_003 forma
								 inner join usuarios usr
										 on usr.usuarioID = forma.usuarioID
										and usr.tipoEstadoID = 1 
								  left join calificaciones calif 
										 on calif.usuarioID = forma.usuarioID
										and calif.seccionID = forma.seccionID
								        and calif.tipoEstadoID = 1
								  WHERE forma.tipoEstadoID = 1
								    and forma.seccionID = '$seccionId'
								   -- and usr.tipoUsuarioID = 2
								   -- and calif.periodoAcademicoID = 1")
						or die(mysqli_error($conn));
	
	if (!$query){
		mysql_close($conn);
		echo"no hay asignaturas";
		return;
	}
?>
<button class="btn" id="btnSalvar">salvar datos</button>
<input type="hidden" name="seccion" id="seccionId" value= <?php echo "'$seccionId'"; ?>  >
<input type="hidden" name="periodo" id="periodo" value= <?php echo "'$periodo'"; ?>  >




<ul class="collapsible popout" data-collapsible="accordion">
    <li>
      <div class="collapsible-header active"><i class="material-icons">list</i>Parcial 1</div>
      <div class="collapsible-body">
      	<table class='bordered highlight' id="tableCalificaciones">
			<thead>
				<tr>
					<th>No. Cuenta</th>
					<th>Nombre Alumno</th>
					<th>Puntaje Calificación</th>
				</tr>
			</thead>
			<tbody>
				<?php
					while ($calificaciones = mysqli_fetch_array($query)){
						$noCuenta = $calificaciones["noCuenta"];
						$nombres = $calificaciones["nombres"];
						$puntaje = $calificaciones["puntajeCalificacion"];

						echo "<tr>
								<td>$noCuenta</td>
								<td>$nombres</td>
								<td contenteditable id='puntaje'>$puntaje</td>
							</tr>";
					}
				?>
			</tbody>
		</table>
      </div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">list</i>Parcial 2</div>
      <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">list</i>Parcial 3</div>
      <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
    </li>
  </ul>



<script>

	$(document).ready(function(){
	    $('.collapsible').collapsible();
	  });


	$("#btnSalvar").click(function (){

		$("#tableCalificaciones tbody tr").each(function (index) {
		    var campo1, campo2, campo3;
		    var noCuentas = [];
		    var calificacion = [];
		    var i = 0;

		    //Recorrer tabla de calificaciones
		    $(this).children("td").each(function (index2){
		        switch (index2){

		            case 0: noCuentas[i] = $(this).text();
		                break;
		            case 1: campo2 = $(this).text();
		                break;
		            case 2: calificacion[i] = $(this).text();
		                break;
		        }
		    });
		            
			//prueba alert(noCuentas[i] + ' - ' + campo2 + ' - ' + calificacion[i]);

		           //pasar datos a funcion php para guardarlos
		    $.ajax({
				type: "get",
				data: { seccionId: $("#seccionId").val(),
				    	cuentas: noCuentas,
				    	calificaciones: calificacion,
				    	periodo: $("#periodo").val()
				      },
				url: "funcionesPHP/salvarCalificaciones.php",
				datatype: 'html'
			}).done(function( response ) {

				alert(response);
					// var node = document.getElementById("calificaciones-contenido");
					// while (node.firstChild){
					//     node.removeChild( node.firstChild );
					// }
					// $(".secciones-calificar-contenido").append(response);
				});


		    });

	});

</script>

<?php 
	mysqli_close($conn);
?>