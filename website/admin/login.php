<?php
session_start();
if (isset($_SESSION['s_priority'])) {
	function redirect(){
		if ($_SESSION['s_priority'] == 3){
			ob_start(); 
			header("Location: uploadScores.php");
			ob_end_flush(); 
		}
		if ($_SESSION['s_priority'] == 1) {
			ob_start(); 
			header("Location: index.php");
			ob_end_flush(); 
		}
	}
	redirect();
}

?>
<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<meta charset="utf-8">
		<style>
			body{
				background: url('imagenes/background-login.jpg') repeat;
				background-position: top; 
			}
			#login-container{
				padding: 10px;
				width: 450px;
				margin: 50px auto;
				background-color: #fff;
				box-shadow: 0 0 3px #999;
				text-align: center;
			}
			input[type="text"], input[type="password"]{
				border: 1px solid #6E6E6E;
				width: 60%;
				padding: 10px;
				padding-left: 6%;
				margin-bottom: 5px;
			}
			.userInput{
				background: url('imagenes/user-icon.png') no-repeat; 
				background-size: 20px 20px;
				background-position: 1% 5px;
			}
			.passInput{
				background: url('imagenes/password-icon.png') no-repeat; 
				background-size: 25px 20px;
				background-position: 0.5% 5px;
			}

			.btn{
				box-sizing: border-box;
				width: 30%;
				height: 30px;
				padding: 5px;
				background: linear-gradient(#29ADD0,#092751);
				border: 1px solid #000;
				border-radius: 0.3em;
				color: #fff;
				text-align: center;
				text-decoration: none;
				font-size: 10pt;
			}

			.btn:hover{
				cursor: pointer;
				box-shadow: 0 0 5px #7D7E7E;	
			}
			.btn:active{
				background: #900;
			}

		</style>
	</head>
	<body>
	<div id='background'>
		<div id="login-container">
				<form action="validar_login.php" method="post">
					<input name="user" type="text" maxlength="20" placeholder='Usuario' autofocus class="userInput" /><br>
					<input name="pw" type="password" placeholder='Contraseña' class="passInput" /><br><br>
					<a style='color:#06F;' href='#'>He olvidado mi contraseña</a><br><br>
					<input type="submit" name="login" id="login" class='btn' value="Ingresar" />	
				</form>
		</div>
	</div>
	</body>
		
	</html>