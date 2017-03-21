
<?php

	include_once("../../connection.php");

	$query = mysqli_query($conn,"SELECT s.seccionID
									   ,s.seccion
								       ,s.asignaturaID
								       ,s.horaInicio
								       ,s.horaFin
								       ,s.edificio
								       ,s.salonClase
									   ,u.nombres		as nombreCatedratico
								  FROM secciones s
								 INNER JOIN usuarios u
									on s.usuarioID = u.usuarioID
								 ORDER BY s.seccion;")
						or die(mysqli_error($conn));
	
	if (!$query){
		mysql_close($conn);
		echo"no hay secciones";
		return;
	}


	echo"<div>
			<table class='bordered highlight centered'>
				<thead>
					<tr>
						<th>Seccion</th>
						<th>Hora de Inicio</th>
						<th>Hora Final</th>
						<th>Edificio</th>
						<th>Aula</th>
						<th>Catedratico</th>
					</tr>
				</thead>";
		while ($dataSecciones = mysqli_fetch_array($query)){

			$seccion = $dataSecciones['seccion'];
			$horaInicio = $dataSecciones['horaInicio'].":00";
			$horafinal = $dataSecciones['horaFin'].":00";
			$edificio = $dataSecciones['edificio'];
			$aula = $dataSecciones['salonClase'];
			$catedratico = $dataSecciones['nombreCatedratico'];
			echo"
			<tbody>
				<tr>
					<td>$seccion</td>
					<td>$horaInicio</td>
					<td>$horafinal</td>
					<td>$edificio</td>
					<td>$aula</td>
					<td>$catedratico</td>
				</tr>
			</tbody>";
		}
	echo"</table>
		<div>";

	$Catedraticos = mysqli_query($conn, "SELECT usuarioID
												   ,nombres
											  FROM usuarios 
											 WHERE tipoUsuarioID = 3
											   AND tipoEstadoID = 1");	

	$Asignaturas = mysqli_query($conn, "SELECT asignaturaID
												  ,descripcion
											 FROM asignaturas
											WHERE tipoEstadoID = 1");

	$periodos = mysqli_query($conn, "SELECT periodoAcademicoID
											,descripcion
									   FROM periodoAcademico
									  WHERE tipoEstadoID = 1");

	if(!$Catedraticos)
			echo "error al cargar catedraticos";

	if(!$Asignaturas)
			echo "error al cargar asignaturas";

	if(!$periodos)
			echo "error al cargar periodos";

	mysqli_close($conn);
?>

<!-- Formulario para agregar secciones -->
<div id="agregarSeccion" class="modal modal-fixed-footer">
	<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat right"><li class="material-icons">close</li></a>
    <div class="modal-content">
	    <div class="modal-header">
			<h4>Registro de Secciones</h4>
		</div>
      
    	<form id="formSeccion" action="funcionesPHP/registrarSeccion.php" method="post" class="col s12">
    		<div class="row">
		        <div class="input-field col s12">
		          <input id="seccion" name="seccion" type="text" class="validate">
		          <label for="seccion">Seccion</label>
		        </div>
		    </div>
	      <div class="row">
	        <div class="input-field">
	          	<select name="asignatura">
	          		<option value="-1">--</option>
		          	<?php
		          		while($data = mysqli_fetch_array($Asignaturas) ){

		          			$id = $data["asignaturaID"];
		          			$descripcion = $data["descripcion"];
		          			echo "<option value='$id'>$descripcion</option>";
		          		}
		          	?>
			    </select>	
			    <label for="asignatura">Asignatura</label>         
	        </div>
	      </div>
	      <div class="row">
	        <div class="input-field">
	          	<select name="catedratico">
		        	<option value="-1">--</option>
			    	<?php
		          		while($data = mysqli_fetch_array($Catedraticos) ){

		          			$id = $data["usuarioID"];
		          			$nombreCatedratico = $data["nombres"];
		          			echo "<option value='$id'>$nombreCatedratico</option>";
		          		}
		          	?>
			    </select>	
			    <label for="catedratico">Catedratico</label>         
	        </div>
	      </div>
	      <div class="row">
	        <div class="input-field col s12">
	          <input id="horaInicio" name="horaInicio" type="number" class="validate" max="20" min="07">
	          <label for="horaInicio">Hora Inicio de Clase</label>
	        </div>
	      </div>
	      <div class="row">
	        <div class="input-field col s12">
	          <input id="horaFin" name="horaFin" type="number" class="validate" max="21" min="08">
	          <label for="horaFin">Hora Fin de Clase</label>
	        </div>
	      </div>
	      <div class="row">
	        <div class="input-field">
	          	<select name="periodo">
		        	<option value="-1">--</option>
		        	<?php
		          		while($data = mysqli_fetch_array($periodos) ){

		          			$id = $data["periodoAcademicoID"];
		          			$descripcion = $data["descripcion"];
		          			echo "<option value='$id'>$descripcion</option>";
		          		}
		          	?>
			    </select>	
			    <label for="periodo">Periodo Academico</label>         
	        </div>
	      </div>
	      <div class="row">
		        <div class="input-field col s12">
		          <input id="edificio" name="edificio" type="text" class="validate">
		          <label for="edificio">Edificio</label>
		        </div>
		    </div>
		    <div class="row">
		        <div class="input-field col s12">
		          <input id="aula" name="aula" type="text" class="validate">
		          <label for="aula">Aula de Clase</label>
		        </div>
		    </div>
	    </form>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancelar</a>
      <button type="submit" form="formSeccion" class="waves-effect waves-green btn-flat">Aceptar</button>
    </div>
  </div>

<!-- Boton agregar -->
<div class="fixed-action-btn">
	<a href="#agregarSeccion" class="btn-floating btn-large waves-effect waves-light red right addSeccion"><i class="material-icons">add</i></a>
</div>


<script>

		$(document).ready(function () {
				$('.addSeccion').leanModal();
				$('select').material_select();
			});
</script>