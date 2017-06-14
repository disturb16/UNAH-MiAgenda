
	<table class="bordered highlight centered">
				<thead>
					<tr>
						<th>Seccion</th>
						<th>Hora de Inicio</th>
						<th>Hora Final</th>
						<th>Edificio</th>
						<th>Aula</th>
						<th>Catedratico</th>
					</tr>
				</thead>
			<tbody>
		@foreach ($data["secciones"] as $seccion)			
				<tr>
					<td>{{ $seccion->seccion }}</td>
					<td>{{ $seccion->horaInicio }}:00</td>
					<td>{{ $seccion->horaFin }}:00</td>
					<td>{{ $seccion->edificio }}</td>
					<td>{{ $seccion->salonClase }}</td>
					<td>{{ $seccion->nombreCatedratico }}</td>
				</tr>			
		@endforeach
		</tbody>
	</table>


<!-- Formulario para agregar secciones -->
<div id="agregarSeccion" class="modal modal-fixed-footer">
	<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat right"><li class="material-icons">close</li></a>
    <div class="modal-content">
	    <div class="modal-header">
			<h4>Registro de Secciones</h4>
		</div>
      
    	<form id="formSeccion" action="/admin/registrarSeccion" method="post" class="col s12">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
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
		          		@foreach($data["asignaturas"] as $asignatura )
		          			<option value="{{$asignatura->asignaturaID}}">{{$asignatura->descripcion}}</option>
		          		@endforeach
			    </select>	
			    <label for="asignatura">Asignatura</label>         
	        </div>
	      </div>
	      <div class="row">
	        <div class="input-field">
	          	<select name="catedratico">
		        	<option value="-1">--</option>
		          		@foreach($data["catedraticos"] as $catedratico )
		          			<option value="{{$catedratico->usuarioID}}">{{$catedratico->nombres}}</option>
		          		@endforeach
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
		          		@foreach($data["periodos"] as $periodo )
		          			<option value="{{$periodo->periodoAcademicoID}}">{{$periodo->descripcion}}</option>
		          		@endforeach
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
				$('.modal').modal();
				$('select').material_select();
			});
</script>