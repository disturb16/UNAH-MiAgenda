<?php
	include("../../connection.php");

	$Solicitudes = mysqli_query($conn, " SELECT asig.descripcion		as asignatura
                                               ,j.descripcion		 	as jornada
										       ,count(sec.jornadaSolicitada) as cantidadSolicitadas
										       ,asig.asignaturaID
                                               ,sec.jornadaSolicitada as jornadaID
										  FROM solicitud_seccion sec
										 INNER JOIN asignaturas asig
												 on asig.asignaturaID = sec.asignaturaID
												and asig.tipoEstadoID = 1
										 INNER JOIN usuarios usr
												 on usr.usuarioID = sec.usuarioID
											    and usr.tipoEstadoID = 1
										 INNER JOIN tipo_jornada j
												 on j.tipoJornadaID = sec.jornadaSolicitada
												and j.tipoEstadoID = 1
										 WHERE sec.tipoEstadoID = 5
										 GROUP BY 
										 	   sec.jornadaSolicitada, sec.asignaturaID");


	if (!$Solicitudes){
		mysqli_close($conn);
		echo "Error al obtener peticiones de clase";
		return;
	}
		
?>

<!-- <table class='bordered highlight'>
	<thead>
		<tr>
			<th>Hora Solicitada</th>
			<th>Descripción Asignatura</th>
			<th>Usuario Solicito</th>
			<th>No.Cuenta Usuario</th>
			<th>Cantidad de Peticiones</th>
		</tr>
	</thead>
	<tbody> -->
	 <?php 
		// while ($data = mysqli_fetch_array($Solicitudes)) {

		// 	$asignatura = utf8_encode($data["asignatura"]);
		// 	$hora = $data["horaSolicitada"].":00";
		// 	// $usuarioSolicito = $data["usuarioSolicito"];
		// 	// $noCuentaSolicito = $data["noCuentaSolicito"];
		// 	$cantidadSolicitadas = $data["cantidadSolicitadas"];

			// echo"			
			// 	<tr>
			// 		<td>$hora</td>
			// 		<td>$asignatura</td>
			// 		<td>$cantidadSolicitadas</td>
			// 	</tr>
			// </tbody>";
		// }

// mysqli_close($conn);
 ?> 
<!-- </tbody>
</table> -->


<ul id="contenedor-calificaciones " class="collapsible popout" data-collapsible="accordion">
<?php 
	
	while ($data = mysqli_fetch_array($Solicitudes) ){

			$jornadaId = $data["jornadaID"];
			$jornada = $data["jornada"];
			$asignaturaID = $data["asignaturaID"];
			$asignatura = $data["asignatura"];
			$cant = $data["cantidadSolicitadas"];

			$qryUsuariosSolic = mysqli_query($conn,"SELECT  u.nombres
														  ,u.noCuenta
													      ,u.correo
													FROM solicitud_seccion sol
														 inner join usuarios u
																 on u.usuarioID = sol.usuarioID
																and u.tipoEstadoID = 1
													WHERE sol.asignaturaID = '$asignaturaID'
													  AND sol.jornadaSolicitada = '$jornadaId'
													  AND sol.tipoEstadoID = 5") or die(mysqli_error($conn));
	

		?>
		<li>
	      <div class="collapsible-header"><i class="material-icons">list</i> <?php echo $asignatura; ?> 
	      <span class="right">Cantidad Solicitudes: <b><?php echo $cant; ?></b></span><br>
	      Jornada <b><?php echo $jornada; ?></b> 
	      </div>
	      <div class="collapsible-body">
	      	
	      	<table class='bordered highlight tablaCalif' id="tableCalificaciones">
			<thead>
				<tr>
					<th>No. Cuenta</th>
					<th>Nombre Alumno</th>
					<th>Correo</th>
				</tr>
			</thead>
			<tbody>	
				<?php


					foreach($qryUsuariosSolic as $solicitud){

							$noCuenta = $solicitud["noCuenta"];
							$nombres = $solicitud["nombres"];
							$correo = $solicitud["correo"];
							
							echo "
								<tr>
									<td>$noCuenta</td>
									<td>$nombres</td>
									<td>$correo</td>
								</tr>";
						

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
</script>