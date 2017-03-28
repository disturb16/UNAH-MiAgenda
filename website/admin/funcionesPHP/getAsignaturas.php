
<?php

	include_once("../../connection.php");

	$query = mysqli_query($conn,"SELECT *
								  FROM asignaturas a
								 WHERE a.tipoEstadoID = 1")
						or die(mysqli_error($conn));
	
	if (!$query){
		mysql_close($conn);
		echo"no hay asignaturas";
		return;
	}


	echo"
			<table class='bordered highlight'>
				<thead>
					<tr>
						<th>Descripción Asignatura</th>
						<th>Código de Asignatura</th>
					</tr>
				</thead>";
		while ($dataSecciones = mysqli_fetch_array($query)){

			$descripcion = $dataSecciones['descripcion'];
			$codigo = $dataSecciones['codigoAsignatura'];
			echo"
			<tbody>
				<tr>
					<td>$descripcion</td>
					<td>$codigo</td>
				</tr>
			</tbody>";
		}
	echo"</table>";
	mysqli_close($conn);
?>

<!-- Formulario para agregar Asignatura -->
<div id="agregarAsignatura" class="modal modal-fixed-footer">
	<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat right"><li class="material-icons">close</li></a>
    <div class="modal-content">
    <div class="modal-header">
		<h4>Registro de Asignaturas</h4>
	</div>
      
    	<form id="formAsignaturas" action="funcionesPHP/registrarAsignatura.php" method="post" class="col s12">
    		<div class="row">
		        <div class="input-field col s12">
		          <input id="descripcion" name="descripcion" type="text" class="validate">
		          <label for="descripcion">Descripción de Asignatura</label>
		        </div>
		    </div>
		    <div class="row">
		        <div class="input-field col s12">
		          <input id="codigo" name="codigo" type="text" class="validate">
		          <label for="codigo">Código de Asignatura</label>
		        </div>
		    </div>	      
	    </form>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancelar</a>
      <button type="submit" form="formAsignaturas" class="waves-effect waves-green btn-flat">Aceptar</button>
    </div>
  </div>

<!-- Boton agregar -->
<div class="fixed-action-btn">
	<a href="#agregarAsignatura" class="btn-floating btn-large waves-effect waves-light red right addSeccion"><i class="material-icons">add</i></a>
</div>


<script>

		$(document).ready(function () {
				$('.addSeccion').leanModal();
				$('select').material_select();
			});
</script>