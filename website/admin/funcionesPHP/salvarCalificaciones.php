
<?php
	include_once("../../connection.php");


	$cuentasArray = $_GET['cuentas'];
	$periodo= mysqli_real_escape_string($conn, $_GET['periodo']);
	$seccion= mysqli_real_escape_string($conn, $_GET['seccionId']);
	$calificaciones=  $_GET['calificaciones'];
	$parcial = mysqli_real_escape_string($conn, $_GET['parcial']);
	$i = 0;
	$errores;

	// pasar a un solo string separado por comas
	$cuentas = implode(", ", $cuentasArray);

	//obtener los ids de las cuentasde usuario
	$userqry = mysqli_query($conn, "SELECT usuarioID
										   ,noCuenta
									  FROM usuarios 
									 WHERE noCuenta in ($cuentas); ");

	if(!$userqry){
		echo mysqli_error($conn);
	}


	//recorrer cada usuario
	while ($usuario = mysqli_fetch_array($userqry) ){

		$usuarioId = $usuario["usuarioID"];
		$cuentaUsuario = $usuario["noCuenta"];

		foreach ($cuentasArray as $index => $cuenta) {

			++$i;

			if ($cuenta != $cuentaUsuario){
				continue;
			}

				// obtener el index correspondiente a la cuenta 
				// para que coincida con el elemento de calificaciones
				$calificacion = $calificaciones[$index];

				$qryCalifGuardada = mysqli_query($conn, "SELECT puntajeCalificacion as puntaje
													 FROM calificaciones
													WHERE seccionID = '$seccion'
													  AND usuarioID = '$usuarioId'
													  AND parcial = '$parcial';");

				if(!$qryCalifGuardada){
					echo mysqli_error($conn);
					mysqli_close($conn);
					return;
				}

				$puntaje = mysqli_fetch_array($qryCalifGuardada);

				if($puntaje["puntaje"] < 0 || $puntaje["puntaje"] == null){
					//insertar calificacion de alumno
					$qryInsert = mysqli_query($conn, "INSERT INTO calificaciones (seccionID, usuarioID, periodoAcademicoID, puntajeCalificacion, tipoEstadoID, parcial, fechaCreo)
													  values  ('$seccion', '$usuarioId', '$periodo', 
													  '$calificacion', 1, '$parcial', now() )"
											  );

					if(!$qryInsert){
						echo mysqli_error($conn);
						mysqli_close($conn);			
						return;
					}

				}else{
					//actualizar calificacion de alumno
					$qryUpdate = mysqli_query($conn,"  UPDATE calificaciones 
														  SET puntajeCalificacion = '$calificacion' 
														WHERE seccionID = '$seccion' 
														  AND usuarioID = '$usuarioId'
														  AND parcial = '$parcial' ");
					if (!$qryUpdate){
						echo mysqli_error($conn);
						mysqli_close($conn);
						return;
					}
				}
				
			
		}// end foreach cuentas
	}//end while

	

	mysqli_close($conn);

?>