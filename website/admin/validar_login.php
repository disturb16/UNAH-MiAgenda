<script>
	function redirecToIndex()
	{
		setTimeout("location.href='testadminPanel.php'");
	}

	function redireccionar()
	{
		setTimeout("location.href='login.php'");
	}
	</script>

<?php
	session_start();

	include ("../connection.php");


	if(isset($_SESSION['userName'])){
		mysqli_close($connn);
		echo "<script> alert ('No pudiste iniciar porque ya hay una sesion iniciada'); </script>";
		header("Location: testadminPanel.php");			
		return;
	}

	if($_POST['pw'] == NULL)
	{
		mysqli_close($conn);
		echo "<script> alert ('Falta la  Contraseña'); </script>";
		echo "<script>history.go(-1);</script>";			
		return;
	}
			
	//escapando las variables
	$username = mysqli_real_escape_string($conn,$_POST['user']);
	$pass = mysqli_real_escape_string($conn,$_POST['pw']);
	$password = md5($pass);

	//Check si la contraseña es correcta
	$query = mysqli_query($conn,"SELECT * 
								   FROM usuarios 
								  WHERE userName = '$username'
								   -- AND tipoEstadoID = 1")
								or die(mysqli_error($conn));

	if(!$query){
		mysqli_close($conn);
		echo "<script> alert('Usuario No valido')</script>";
		echo "<script>history.go(-1);</script>";
		return;
	}
		
	$data = mysqli_fetch_array($query);

	if($data['pass'] != $password){
		mysqli_close($conn);
		$_SESSION['userName'] = NULL;
		$_SESSION['tipoUsuarioID'] = NULL;
		echo "<script> alert('Contraseña Incorrecta')</script>";
		echo "<script>history.go(-1);</script>";
		return;
	}

	//Extraer datos del usuario
	$_SESSION['tipoUsuarioID'] = $data['tipoUsuarioID'];
	$_SESSION['usuarioID'] = $data['usuarioID'];			

	mysqli_close($conn);

	echo $_SESSION["userName"];		

	if ($_SESSION['tipoUsuarioID'] == 3){

		ob_start(); 
		echo "has iniciado sesion <b> $user  </b> espera un momento";
		header("Location: calificaciones.php");
		ob_end_flush(); 
	}
		
	if ($_SESSION['tipoUsuarioID'] == 1) {
		
		ob_start(); 
		echo "has iniciado sesion <b> $user  </b> espera un momento";
		echo "<script>redirecToIndex();</script>";
		ob_end_flush(); 
	}
					
	?>