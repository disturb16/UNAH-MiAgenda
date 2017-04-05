<?php
	session_start();
	include_once("../../connection.php");

	$noCuenta = mysqli_real_escape_string($conn, $_GET["noCuenta"]);


	$qryInsertUsuario = mysqli_multi_query($conn, "insert into usuarios (userName, nombres, pass, noCuenta, fechaNacimiento, correo,    													    tipoUsuarioID, fechaCreo, tipoEstadoID)
										SELECT concat('usuario', s.noCuenta)
												,s.nombres
										        ,s.pass
										        ,s.noCuenta
										        ,s.fechaNacimiento
										        ,s.email
										        ,3
										        ,now()
										        ,1        
										  FROM solicitud_cuenta s
										WHERE noCuenta = '$noCuenta'
										  AND tipoEstadoID = 5
										order by solicitudCuentaID desc
										LIMIT 1;

										UPDATE solicitud_cuenta 
										SET tipoEstadoID = 4
										WHERE noCuenta = '$noCuenta'
										  AND tipoEstadoID = 5;");

	if(!$qryInsertUsuario)
		echo mysqli_error($conn);
	else
		echo "Usuario registrado exitosamente";


	mysqli_close($conn);
?>