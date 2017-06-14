 @extends("masterPage")

 @section('contenido')
<!-- Barra de carga -->
		  <div class="progress">
		      <div class="indeterminate" style="width: 70%"></div>
		  </div>
		        
		  <div id="secciones" class="col s12"></div>
		  <div id="noticias" class="col s12"></div>
		  <div id="asignaturas" class="col s12"></div>
		  <div id="solicitudes" class="col s10"></div>
		  <div id="forma" class="col s12">
		  	<div class="row">
			  	<div class="input-field col s5">
				    <select class="secciones-forma" id="secciones">
				      <option value="" disabled selected>Elija una sección</option>
				    </select>
				</div>
				<div class="row" id="contenido-forma"></div>
		    </div>

		  </div>
		  <div id="tickets" class="col s12"></div>
@endsection