
<?php
	include_once("../../connection.php");


	$cuentasArray = $_GET['cuentas'];
	$periodo= $_GET['periodo'];
	$seccion= $_GET['seccionId'];
	$calificaciones= $_GET['calificaciones'];
	$parcial = 1;

	// pasar a un solo string separado por comas
	$cuentas = implode(", ", $cuentasArray);


	//obtener los ids de las cuentasde usuario
	$userqry = mysqli_query($conn, "SELECT usuarioID
										   ,noCuenta
									  FROM usuarios 
									 WHERE noCuenta in ($cuentas) ");


	//recorrer cada usuario
	while ($usuario = mysqli_fetch_array($userqry) ){

		$usuarioId = $usuario["usuarioID"];
		$cuentaUsuario = $usuario["noCuenta"];

		foreach ($cuentasArray as $index => $cuenta) {

			if ($cuenta == $cuentaUsuario){

				// obtener el index correspondiente a la cuenta 
				// para que coincida con el elemento de calificaciones
				$calificacion = $calificaciones[$index];

				//insertar calificacion de alumno
				$scoreInsert = mysqli_query($conn,"INSERT INTO calificaciones (seccionID, usuarioID, periodoAcademicoID, puntajeCalificacion, tipoEstadoID, parcial, fechaCreo) 
    																   values( '$seccion', '$usuarioId', '$periodo', '$calificacion', 1, '$parcial', now() )");

				if (!$scoreInsert){
					echo "error al salvar puntaje.... ".mysqli_error($conn);
				}
				else{
					echo "puntaje de cuenta ". $cuenta." salvada";
				}
			}// end if
		}// end foreach
	}//end while



	mysqli_close($conn);

?>