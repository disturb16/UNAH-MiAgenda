<!DOCTYPE html>
<?php
	session_start();
	include ("../connection.php");
?>
<html>
	<head>

	<script>
	function redirecToIndex()
	{
		setTimeout('location.href='index.php'');
	}

	function redireccionar()
	{
		setTimeout('location.href='login.php'');
	}
	</script>
	</head>

	<body>
		<?php

		if(isset($_SESSION['userName'])){
			mysqli_close($connn);
			echo "<script> alert ('No pudiste iniciar porque ya hay una sesion iniciada'); </script>";
			echo "<script>redirecToIndex();</script>";			
			return;
		}

		if($_POST['pw'] == NULL)
		{
			mysqli_close($connn);
			echo "<script> alert ('Falta la  Contraseña'); </script>";
			echo "<script>redireccionar();</script>";			
			return;
		}
			
		//escapando las variables
		$username = mysqli_real_escape_string($conn,$_POST['user']);
		$pass = mysqli_real_escape_string($conn,$_POST['pw']);
		$password = md5($pass);

		//Check si la contraseña es correcta
		$query = mysqli_query($conn,"SELECT * 
									   FROM usuarios 
									  WHERE userName = '$username'")

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
		$_SESSION['userName'] = $data['userName'];
		$_SESSION['tipoUsuarioID'] = $data['tipoUsuarioID'];
		$_SESSION['usuarioID'] = $data['usuarioID'];
		$user = $_SESSION['userName'];			

		
		
		if ($_SESSION['tipoUsuarioID'] == 3){
			mysqli_close($conn);
			ob_start(); 
			echo "has iniciado sesion <b> $user  </b> espera un momento";
			header("Location: uploadScores.php");
			ob_end_flush(); 
		}
		
		if ($_SESSION['tipoUsuarioID'] == 1) {
			mysqli_close($conn);
			ob_start(); 
			echo "has iniciado sesion <b> $user  </b> espera un momento";
			header("Location: index.php");
			ob_end_flush(); 
		}
					
	?>
	</body>
</html>