<?php

	include_once("../../connection.php");

	$query = mysqli_query($conn,"SELECT forma.usuarioID
									   ,usr.noCuenta
									   ,usr.nombres
								       ,calif.puntajeCalificacion
								  FROM forma_003 forma
								 inner join usuarios usr
										 on usr.usuarioID = forma.usuarioID
										and usr.tipoEstadoID = 1 
								  left join calificaciones calif 
										 on calif.usuarioID = forma.usuarioID
										and calif.seccionID = forma.seccionID
								        and calif.tipoEstadoID = 1
								  WHERE forma.tipoEstadoID = 1
								    and forma.seccionID = 1
								   -- and usr.tipoUsuarioID = 2
								   -- and calif.periodoAcademicoID = 1")
						or die(mysqli_error($conn));
	
	if (!$query){
		mysql_close($conn);
		echo"no hay asignaturas";
		return;
	}
?>

<table class='bordered highlight'>
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

<?php 
	mysqli_close($conn);
?>