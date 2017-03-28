
<?php
include_once("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);

	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();

if ($_POST){
	$cuenta= $_POST['cuenta'];
	$periodo= $_POST['periodo'];
	$year= $_POST['year'];
	$seccion= $_POST['seccion'];
	$fecha= $_POST['fecha'];
	$score= $_POST['score'];

	$variablesQry = mysqli_query($con,
		"SELECT fechaParcial, fechaInicio, fechaFinal 
    	from secciones where seccion = '$seccion' ");

	if (!$variablesQry)
		echo "error al seleccionar variables";
	else{
		$vars = mysqli_fetch_array($variablesQry);
		$fechaParcial = $vars["fechaParcial"];
		$fechaInicio = $vars["fechaInicio"];
		$fechaFinal = $vars["fechaFinal"];

		$scoreInsert = mysqli_query($con,"INSERT INTO scores (periodo,year,cuenta,score,fecha, seccionEvaluada, fechaParcial, fechaInicio, fechaFinal) 
    	values( '$periodo', '$year', '$cuenta', '$score', '$fecha', '$seccion', '$fechaParcial', '$fechaInicio', '$fechaFinal' );");

    	if (!$scoreInsert) {
    		echo "Error al insertar nota";
    	}else{
    		$userQry = mysqli_query($con, "SELECT userID from users WHERE cuenta = '$cuenta'");
    		$userData = mysqli_fetch_array($userQry);
    		$userID = $userData["userID"];

    		$updateForma = mysqli_query($con, "update forma_003 set evaluado = 1
    						where userID = '$userID' AND seccion = '$seccion' ");

    		if (!$updateForma) {
    			echo "error al actualizar Forma 003";
    		}else{
    			echo "<script>alert('Alumno evaluado');</script>
			  <script>history.go(-1)</script>";
    		}
    	}
	}


}

mysqli_close($con);

?>