<script src="../tinymce_4.2.1/tinymce/js/tinymce/tinymce.min.js"></script>
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

<form id="publiNoti" action="#!" method="post" class="col s12">
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
		    <div class="row">
		        <div class="input-field col s12">
		          <textarea name='novedad' placeholder='Nombre_del_evento' rows='20'></textarea>
		          <!-- <label for="codigo">Código de Asignatura</label> -->
		        </div>
		    </div>      
	    </form>

