
<?php
include_once("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);

	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
?>



<?php
$cuenta= $_GET['cuenta'];
$periodo= $_GET['periodo'];
$year= $_GET['year'];
$seccion= $_GET['seccion'];
$fecha= $_GET['fecha'];

		echo"
		
<div id='editContent'>
<link href='respcss.css' rel='stylesheet' media='all'/>
<style>
	#formSave{
		font-family: openSans, Verdana, Geneva, sans-serif;
		background-color: #fff;
		width: 90%;
		margin: 10px auto;
		padding: 0 4% 1% 4%;
		border-radius: 0.4em;
	}
	textarea{
		width: 92%;
	}

	input[type='text']{
		max-width: 90%;
	}
	.btn{
		width: 30%;
		min-width: 70px;
	}
</style>";

echo"
	<form id='formSave' action='saveScore.php' method='POST' >

	<input type='hidden' name='periodo' value='$periodo' />
	<input type='hidden' name='year' value='$year' />
	<input type='hidden' name='seccion' value='$seccion' />
	<input type='hidden' name='fecha' value='$fecha' />
";?>

	<div id='formContent'>
	<div align='right'>
		<span style='align:left;'> <a href='#' style='text-decoration:none;' onclick="closeEvaluation()"><b>X</b></a></span>
	</div>	
<?php
	echo"
	<span>Alumno: </span> <input type='text' name='cuenta' value='$cuenta' readonly><br>	
	<textarea name='score' cols='25' rows='5' placeholder='Ingresa la nota' required=''></textarea><br>
	<input type='submit' class='btn' value='Guardar'/>
	</form>
	</div>
</div>";
?>