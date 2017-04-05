<?php
	session_start();
	include("../../connection.php");
?>
	<table class='bordered highlight' id="solicitudesTable">
		<thead>
			<tr>
				<th>No. de Cuenta</th>
				<th>Nombre</th>
				<th>Correo Electrónico</th>
				<th>Fecha de Solicitud</th>
			</tr>
		</thead>
		<tbody>
<?php

	$qrySolicitudes = mysqli_query($conn,"SELECT noCuenta
												 ,nombres
												 ,email
												 ,date_format(fechaCreo, '%d/%m/%Y') as fecha
									       FROM solicitud_cuenta
									 	  where tipoEstadoID = 5 ");
	if(!$qrySolicitudes){
		mysql_close($conn);
		echo"Error al cargar lista de alumnos";
		return;
	}		

	while($data = mysqli_fetch_array($qrySolicitudes)){
		$cuenta = $data["noCuenta"];
		$nombre = $data["nombres"];
		$correo = $data["email"];
		$fecha = $data["fecha"];
		echo"
			<tr>
				<td>$cuenta</td>
				<td>$nombre</td>
				<td>$correo</td>
				<td>$fecha</td>
				<td><button class='btn amber lighten-1' onclick='validarSolicitud($cuenta)'>Validar</button></td>
			</tr>";
	}

	mysqli_close($conn);
?>
		</tbody>
	</table>