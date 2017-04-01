<?php
	include_once("../../connection.php");

	$qryNoti = mysqli_query($conn,"select * from noticias");

	while($qry = mysqli_fetch_array($qryNoti)){
		$titulo = $qry['tituloNoticia'];
		$contenido = $qry['contenidoNoticia'];
		$imagenPortada = $qry['imagenPortada'];
		$descripcion = $qry['descripcionNoticia'];
		$fechaCreo = $qry['fechaCreo'];
		?>
			<div class='col s12 m7'>
		    <div class="card horizontal">
		      <div class="card-image">
		        <img src=<?php echo "'../"."$imagenPortada'"; ?> style="max-height: 250px;">
		      </div>
		      <div class="card-stacked">
		      	<h2 class="header"><?php echo $titulo; ?></h2>
		        <div class="card-content">
		          <p><?php echo $descripcion; ?></p>
		        </div>
		        <div class="card-action">
		          <a href="#">Ver detalle de noticia <i class="material-icons">trending_flat</i></a>
		        </div>
		      </div>
		    </div>
		  </div>
	<?php
	}

	mysqli_close($conn);
?>

<!-- Formulario para agregar secciones -->
<div id="Publicar" class="modal modal-fixed-footer" style="max-height: 80%;height: 80%;">

	<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat right"><li class="material-icons">close</li></a>
	<div class="modal-header center">
		<h4>Publicar Noticia</h4>
	</div>
    <div class="modal-content" style="margin:0">
    
		<form id="publiNoti" action="funcionesPHP/publicarNoticia.php" method="post" enctype="multipart/form-data" class="col s12">
			<p>
				<input class="with-gap" name="tipoPublicacion" type="radio" id="noti" value="n" checked />
				<label for="noti">Noticia</label>

				<input class="with-gap" name="tipoPublicacion" type="radio" id="evento" value="e" />
				<label for="evento">Evento</label>
			</p>
    		<div class="row">
		        <div class="input-field col s12">
		          <input id="titulo" name="titulo" type="text" class="validate">
		          <label for="titulo">Titulo de Noticia</label>
		        </div>
		    </div>
		    <div class="row">
		        <div class="input-field col s12">
		          <input id="descripcionNoti" name="descripcionNoti" type="text" maxlength="200"  
		           class="validate">
		          <label for="descripcionNoti">Descripción de Noticia</label>
		        </div>
		    </div>
		    <div class="row">
		    	<div class="file-field input-field">
			      <div class="btn">
			        <span>Portada</span>
			        <input type="file" name="portadaImg" accept="image/*" required>
			      </div>
			      <div class="file-path-wrapper">
			        <input class="file-path validate" type="text">
			      </div>
			    </div>
		    </div>
		    <div class="row">
		        <div class="input-field col s12">
		          <textarea name='contenido' placeholder='Nombre_del_evento' rows='50'></textarea>
		        </div>
		    </div>      
	    </form>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancelar</a>
      <button type="submit" form="publiNoti" class="waves-effect waves-green btn-flat">Aceptar</button>
    </div>
  </div>


<!-- Boton agregar -->
<div class="fixed-action-btn">
	<a href="#Publicar" class="btn-floating btn-large waves-effect waves-light red right publicar"><i class="material-icons">add</i></a>
</div>

<script src="tinymce_4.2.1/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
	tinymce.init({

			selector: "textarea",

			plugins: [

				"advlist autolink lists link image charmap print preview anchor",

				"searchreplace visualblocks code fullscreen emoticons contextmenu",

				"insertdatetime media imagetools table contextmenu paste textcolor jbimages"

			],

			toolbar: "insertfile undo redo preview | styleselect forecolor backcolor emoticons | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",

			 gecko_spellcheck: true,

	image_advtab: true,

	relative_urls: false

		});
</script>
<script>

		$(document).ready(function () {
				$('.modal').modal();
				$('select').material_select();
			});
</script>