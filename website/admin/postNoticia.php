<?php

include("connection.php");


// Declaramos la variaBle para guardar la fecha en la que se publicó la noticia

$fecha=date("Y/n/d "); 

// Conectamos a la base de datos 

$con=mysqli_connect("$_host","$_user","$_pass","$_db");

$noticia= mysqli_real_escape_string($con,$_POST['novedad']);
$id = mysqli_real_escape_string($con,$_POST['id']);
$descrip = mysqli_real_escape_string($con,$_POST['descrip']);

$titulo = mysqli_real_escape_string($con, $_POST['titulo']);

$type = $_POST['type'];
$ruta_imagen = $_FILES['imagen']['name'];

$edited = $_POST['edited'];
// Aquí lo que hacemos es que si algún listillo quiere ir directamente al archivo enviar.php para publicar una noticia en blanco, le salte un error
if ($edited == 'f'){
if (!empty($_POST['autor']) && !empty($_POST['titulo']) && !empty($_POST['novedad']) && !empty($_POST['descrip']) && $_FILES['imagen']['type'] != '')
{

if ($type == 'n'){

	// guardar imagen de muestra
	$img_pathTo_save = "imagenes/portada_noticias/".$_FILES['imagen']['name'];

	$target=$_SERVER['DOCUMENT_ROOT']."/androidTest/imagenes/portada_noticias/";

	$img_path=$target.$_FILES['imagen']['name'];

	move_uploaded_file($_FILES['imagen']['tmp_name'],$img_path);

	

	// Ingresar la noticia en la base de datos

	$insert = mysqli_query ($con,"INSERT INTO noticias (autor, titulo, imagen, noticia,fecha,descripcion) 

		VALUES ('$_POST[autor]', '$titulo', '$img_pathTo_save', '$noticia','$fecha','$descrip')");

}if ($type == 'e'){

		// guardar imagen de muestra
	$img_pathTo_save = "imagenes/portada_eventos/".$_FILES['imagen']['name'];

	$target=$_SERVER['DOCUMENT_ROOT']."/androidTest/imagenes/portada_eventos/";

	$img_path=$target.$_FILES['imagen']['name'];

	move_uploaded_file($_FILES['imagen']['tmp_name'],$img_path);

		$insert = mysqli_query($con,"INSERT INTO eventos (autor, titulo, imagen, evento,fecha,descripcion) 

		VALUES ('$_POST[autor]', '$titulo', '$img_pathTo_save', '$noticia','$fecha','$descrip')");

}
if(!$insert){

	echo "error al insertar noticia";

}else

	echo "se ha publicado la noticia";
}
else {
	echo "<script>alert('Tienes que completar todos los campos para publicar tu noticia!') </script>";

	mysqli_close($con);

	echo "<script>history.go(-1);</script>";
}
}
if ($edited == 't'){
	if (!empty($_POST['autor']) && !empty($_POST['titulo']) && !empty($_POST['novedad']) && !empty($_POST['descrip']) )
	{	
		$update = mysqli_query($con,"UPDATE noticias SET autor = '$_POST[autor]', titulo = '$titulo', descripcion = '$descrip', noticia = '$noticia' WHERE id_noticia = '$id' ");
	if(!$update)
		echo "error al insertar noticia";
	else
		echo "se ha publicado la noticia";	
	}else{
		echo "<script>alert('Tienes que completar todos los campos!') </script>";	
		mysqli_close($con);	
		echo "<script>history.go(-1);</script>";		
	}
	
}
?>