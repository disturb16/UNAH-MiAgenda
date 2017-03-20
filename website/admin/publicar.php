<!DOCTYPE html>

<html lang='es'>

<?php

session_start();
include_once ("connection.php");

	  $con = mysqli_connect($_host,$_user,$_pass,$_db);
	  $id = NULL;
?>

<head>

<META NAME="Description" CONTENT="publicar noticias">

<META charset="utf-8">

<title>Publicar noticias</title>
		<script src="dist/jquery.magnific-popup.min.js"></script>
<script>
function redireccionar() 
{
	setTimeout("location.href='index.php'");

}
</script>
		<script src="javascript/jquery-1.11.2.min.js"></script>
<script src="tinymce_4.2.1/tinymce/js/tinymce/tinymce.min.js">

</script>
		<script src="dist/jquery.magnific-popup.min.js"></script>
<script>
function Fecha(){
	var fecha =document.getElementById("fecha");
	var f = new Date();
	fecha.value = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear();
	}

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

		$(document).ready(function() {

			$('.extendList').magnificPopup({

				type: 'ajax',

				alignTop:true,

				closeOnContentClick: false

			});

		});

	</script>
		<link rel="stylesheet" href="dist/magnific-popup.css">
</head>



<body onLoad="Fecha()">



<?php
//$id = mysqli_real_escape_string($con,$_GET['id']);
$noticia = "";
$titulo = "";
$autor = "";
$descrip = "";
$edited = "f";
	if ($_SESSION['s_priority'] == 1)

{
	
if ($id != NULL){
	$result = mysqli_query($con,"SELECT * FROM noticias WHERE id_noticia='$id' ") or die(mysqli_error());		

	$qry = mysqli_fetch_assoc($result);
	$titulo = $qry['titulo'];
	$autor = $qry['autor'];
	$descrip = $qry['descripcion'];
	$noticia=$qry['noticia'];
	$edited = "t";
}
	
echo "

<div id='noticia' class='div_oculto'><h1>Publicar Noticias o Eventos</h1>

<form enctype='multipart/form-data' method='post' action='postNoticia.php'>

Noticia<input name='type' type='radio' value='n' checked>

Evento<input name='type' type='radio' value='e'><br/>

<label><b>Título de la noticia</b><br/><input type='text' name='titulo' maxlength='255' value='$titulo' /></label><br/><br/>



<label><b>Descripcion de noticia</b></br><input type='text' name='descrip' maxlength='300' value='$descrip' /></label><br/><br/>



<label><b>Selecciona imagen de portada</b></br></label><input name='imagen' type='file'/><br/><br/>

<textarea name='novedad' placeholder='Nombre_del_evento' rows='20'> $noticia </textarea><br/><br/>

<input type='hidden' name='edited' value='$edited' />
<input type='hidden' name='id' value='$id' />
<input type='hidden' name='autor' value='$_SESSION[s_username]' />
<button type='submit'>Publicar noticia</button>

</form>

</div>
";


}else

{

echo "<script> alert('no tienes el permiso para ingresar a esta pagina')</script>

		<script>redireccionar();</script>";



}

?>

</body>

</html>