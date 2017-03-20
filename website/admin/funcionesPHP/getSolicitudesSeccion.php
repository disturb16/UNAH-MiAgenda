<?php
	include("../../connection.php");

	$Solicitudes = mysqli_query($conn, " SELECT sec.horaSolicitada
											   ,asig.descripcion		as asignatura
										       -- ,usr.nombres				as usuarioSolicito
										       -- ,usr.noCuenta			as noCuentaSolicito
										       ,count(sec.horaSolicitada) as cantidadSolicitadas
										  FROM solicitud_seccion sec
										 INNER JOIN asignaturas asig
												 on asig.asignaturaID = sec.asignaturaID
												and asig.tipoEstadoID = 1
										 INNER JOIN usuarios usr
												 on usr.usuarioID = sec.usuarioID
											    and usr.tipoEstadoID = 1
										 WHERE sec.tipoEstadoID = 5
										 GROUP BY 
										 	   sec.horaSolicitada, sec.asignaturaID");


	if (!$Solicitudes){
		mysql_close($conn);
		echo "Error al obtener peticiones de clase";
		return;
	}
		
?>

<table class='bordered highlight'>
	<thead>
		<tr>
			<th>Hora Solicitada</th>
			<th>Descripción Asignatura</th>
			<!-- <th>Usuario Solicito</th>
			<th>No.Cuenta Usuario</th> -->
			<th>Cantidad de Peticiones</th>
		</tr>
	</thead>
	<tbody>
	<?php
		while ($data = mysqli_fetch_array($Solicitudes)) {

			$asignatura = utf8_encode($data["asignatura"]);
			$hora = $data["horaSolicitada"].":00";
			// $usuarioSolicito = $data["usuarioSolicito"];
			// $noCuentaSolicito = $data["noCuentaSolicito"];
			$cantidadSolicitadas = $data["cantidadSolicitadas"];

			echo"			
				<tr>
					<td>$hora</td>
					<td>$asignatura</td>
					<td>$cantidadSolicitadas</td>
				</tr>
			</tbody>";
		}

mysqli_close($conn);
?>
</tbody>
</table>