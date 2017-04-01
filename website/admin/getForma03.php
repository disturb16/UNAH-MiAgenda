<?php
	session_start();
	include_once("../connection.php");

	$seccionID = mysqli_real_escape_string($conn, $_GET["seccionId"]);

  	$qryForma = mysqli_query($conn, "SELECT distinct usr.usuarioID
												   ,usr.noCuenta 		
												   ,usr.nombres 		as nombreCompleto
											       ,usr.userName		as usuario
												   ,usr.correo
											  from forma_003 forma
											 inner join usuarios usr
													 on usr.usuarioID = forma.usuarioID
											     -- and usr.tipoUsuarioID = 2
											        and usr.tipoEstadoID = 1
										 where forma.seccionID = '$seccionID' ");

  	if(!$qryForma){
  		echo "Error al obtener alumnos matriculados ..".mysqli_error($conn);
  	}

  	$qryAlumnosAgregar = mysqli_query($conn," SELECT usr.usuarioID
													,usr.noCuenta
													,usr.userName 	as usuario
													,usr.nombres	as nombreCompleto
													,usr.correo
											from usuarios usr
											where not exists(
															select usuarioID 
															  from forma_003 forma	  
															 where forma.seccionID = '$seccionID'
															   and forma.usuarioID = usr.usuarioID
															   and forma.tipoEstadoID = 1
															) ");

  	if(!$qryAlumnosAgregar){
  		echo "Error al obtener alumnos para adicionar..".mysqli_error($conn);
  	}


  ?>

 <div>
	<table class='bordered highlight centered'>
		<thead>
			<tr>
				<th>no. Cuenta</th>
				<th>Nombre Alumno</th>
				<th>Correo electrónico</th>
				<th>usuario Alumno</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while ($data = mysqli_fetch_array($qryForma)){

			$noCuenta = $data['noCuenta'];
			$nombreCompleto = $data['nombreCompleto'];
			$usuario = $data['usuario'];
			$correo = $data['correo'];
			echo"		
			<tr>
				<td>$noCuenta</td>
				<td>$nombreCompleto</td>
				<td>$correo</td>
				<td>$usuario</td>
			</tr>";		
		}
		?>
		</tbody>
	</table>
 </div>

  <!-- Modal Structure -->
  <div id="agregarAlumnos" class="modal">
  		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat right"><li class="material-icons">close</li></a>
    <div class="modal-content">
      <h4>Adicionar Alumno</h4>
      <table class='bordered highlight centered'>
		<thead>
			<tr>
				<th>no. Cuenta</th>
				<th>Nombre Alumno</th>
				<th>Correo electrónico</th>
				<th>usuario Alumno</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if(mysqli_num_rows($qryAlumnosAgregar) == 0){
			echo "<span class='red-text darken-1'>No hay alumnos disponibles para esta sección.</span>";
		}
		while ($data = mysqli_fetch_array($qryAlumnosAgregar)){

			$usuarioId = $data["usuarioID"];
			$noCuenta = $data['noCuenta'];
			$nombreCompleto = $data['nombreCompleto'];
			$usuario = $data['usuario'];
			$correo = $data['correo'];
			echo"		
			<tr>
				<td>$noCuenta</td>
				<td>$nombreCompleto</td>
				<td>$correo</td>
				<td>$usuario</td>
				<td><button class='btn amber lighten-1' onclick='adicionarAlumno($usuarioId, $seccionID)'>Adicionar</button></td>
			</tr>";		
		}
		?>
		</tbody>
	</table>
    </div>
  </div>


	<!-- Boton agregar -->
	<div class="fixed-action-btn">
		<a href="#agregarAlumnos" class="btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">add</i></a>
	</div>


	<script>
		$(document).ready(function () {
    		$('.modal').modal();
    	});
	</script>
<?php
	mysqli_close($conn);
?>

