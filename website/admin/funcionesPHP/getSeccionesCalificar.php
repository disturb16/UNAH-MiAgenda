<?php

	include_once("../../connection.php");

	$seccionId = mysqli_real_escape_string($conn, $_GET["seccionId"]);
	$usuarioId = mysqli_real_escape_string($conn, $_GET["usuarioId"]);
	$periodo = mysqli_real_escape_string($conn, $_GET["periodo"]);


	$parcialesqry = mysqli_query($conn, "SELECT parcial 
									    FROM seccion_parcial 
									   WHERE seccionID = '$seccionId' ");

	$query = mysqli_query($conn,"SELECT forma.usuarioID
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


<ul id="contenedor-calificaciones" class="collapsible popout" data-collapsible="accordion">
<?php 
	
	while ($parciales = mysqli_fetch_array($parcialesqry) ){
			$parcial = $parciales["parcial"];
		?>
		<li>
	      <div class="collapsible-header"><i class="material-icons">list</i>Parcial <?php echo $parcial; ?></div>
	      <div class="collapsible-body">
	      	<?php echo "<input type='hidden' id='parcial$parcial' class='parcial' value='$parcial'>";    ?>
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


					foreach($query["parcial"] as $calif){
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
					// while ($calificaciones = mysqli_fetch_array($query)){
					// 	$noCuenta = $calificaciones["noCuenta"];
					// 	$nombres = $calificaciones["nombres"];
					// 	$puntaje = $calificaciones["puntajeCalificacion"];
					// 	$califParcial = $calificaciones["parcial"];

					// 	if($califParcial == $parcial){
					// 		echo "
					// 		<tr>
					// 			<td>$noCuenta</td>
					// 			<td>$nombres</td>
					// 			<td contenteditable id='puntaje'>$puntaje</td>
					// 		</tr>";
					// 	}//end of parcial validation						
					// }//end of califcacion while
				?>				
			</tbody>
		</table>

	      </div>
	    </li>

<?php	}// end of parciales while

?>
</ul>

<!-- <ul class="collapsible popout" data-collapsible="accordion">
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
				<tr>
				<?php
					// while ($calificaciones = mysqli_fetch_array($query)){
					// 	$noCuenta = $calificaciones["noCuenta"];
					// 	$nombres = $calificaciones["nombres"];
					// 	$puntaje = $calificaciones["puntajeCalificacion"];

					// 	echo "
					// 			<td>$noCuenta</td>
					// 			<td>$nombres</td>
					// 			<td contenteditable id='puntaje'>$puntaje</td>
					// 		";
					// }
				?>
				</tr>
			</tbody>
		</table>
      </div>
    </li>
    
    <li>
      <div class="collapsible-header"><i class="material-icons">list</i>Parcial 3</div>
      <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
    </li>
  </ul> -->



<script>

	$(document).ready(function(){
	    $('.collapsible').collapsible();
	  });


	$("#btnSalvar").click(function (){

		var parcialId = 0;
		//recorrer cada lote de calificaciones
		$(".collapsible-body").each(function (index) {

			var parcial = $(this).children(".parcial").val();


			//Recorrer tabla de calificaciones
			$("#tableCalificaciones tbody tr").each(function (tableIndex) {
			    var campo1, campo2, campo3;
			    var noCuentas = [];
			    var calificacion = [];
			    var i = 0;

			    //Recorrer columnas
			    $(this).children("td").each(function (rowIndex){
			        switch (rowIndex){

			            case 0: noCuentas[i] = $(this).text();
			                break;
			            case 1: campo2 = $(this).text();
			                break;
			            case 2: calificacion[i] = $(this).text();
			                break;
			        }
			    });
			            
				//alert(noCuentas[i] + ' - ' + campo2 + ' - ' + calificacion[i] +' - '+parcial); // prueba

			           //pasar datos a funcion php para guardarlos
			    $.ajax({
					type: "get",
					data: { seccionId: $("#seccionId").val(),
					    	cuentas: noCuentas,
					    	calificaciones: calificacion,
					    	periodo: $("#periodo").val(),
					    	parcial: parcial
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


			 });//end of row de tabla

		});// end of cuerpo de calificaciones

	});





</script>

<?php 
	mysqli_close($conn);
?>