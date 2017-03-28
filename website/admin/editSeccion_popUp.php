
<?php
include_once("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);

	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();

?>



<?php
$qry = mysqli_query($con, "SELECT * FROM catedraticos");
$qryM = mysqli_query($con, "SELECT * FROM materias");
		echo"
		
		<div id='editContent'>
		<style>
table, th, td{
    border-collapse: collapse;
	text-align: center;
}
th, td {
	text-align:center;
}

#editContent{
	font-size: 10pt;
	background-color: #fff;
}
input[type='text']{
	width:90%;
}

input[type='button']{
	margin: 0 auto;
}
select{
	width:80%;
}

</style>";

echo"
			<form action='saveSeccion.php' method='POST' >
				<table id='nuevaSeccion' style='width:90%; margin:0 auto;'>
				<tr>
					<th>Seccion</th>
					<th>Materia</th>
					<th>Hora de Inicio</th>
					<th>Hora final</th>
					<th>Periodo</th>
					<th>Año</th>
					<th>Edificio</th>
					<th>Aula</th>
					<th>Catedratico</th>
				</tr>";
			echo"
				<tr>
					<td><input type='text' name='seccion' /></td>
					<td><select name='materia'>";
					while($dataM = mysqli_fetch_array($qryM)){
						$idM = $dataM["materiaID"];
						$nombreM = utf8_encode($dataM["nombreMateria"]);
						echo"
						<option value='$idM'>$nombreM</option>";
					}
					echo"
					</select></td>
					<td><input type='text' name='horaI' /></td>
					<td><input type='text' name='horaF' /></td>
					<td><input type='text' name='periodo' /></td>
					<td><input type='text' name='year' /></td>
					<td><input type='text' name='edificio' /></td>
					<td><input type='text' name='aula' /></td>
					<td><select name='catedratico'>";
					while($dataCate = mysqli_fetch_array($qry)){
						$id = $dataCate["catedraticoID"];
						$nombre = $dataCate["nombreCatedratico"];
						echo"
						<option value='$id'>$nombre</option>";
					}
					echo"
					</select></td>
					<td id='save'><input type='submit' value='Guardar'></td>
				</tr>
			";
		
		echo"</table>
		</form>
			</div>";



?>