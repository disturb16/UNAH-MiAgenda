<?php

	include("../../connection.php");

	$usuario = 1;// mysqli_real_escape_string($con,$_POST['usuario']);
	$noticia= mysqli_real_escape_string($conn,$_POST['contenido']);
	$descrip = mysqli_real_escape_string($conn,$_POST['descripcionNoti']);

	$titulo = mysqli_real_escape_string($conn, $_POST['titulo']);

	$type = $_POST['tipoPublicacion'];
	$ruta_imagen = $_FILES['portadaImg']['name'];

	//$edited = $_POST['edited'];
	// if ($edited == 'f'){

	if (empty($_POST['autor']) && empty($_POST['titulo']) && empty($_POST['novedad']) && empty($_POST['descrip']) && $_FILES['portadaImg']['type'] == '')
	{
		mysqli_close($conn);
		echo "<script>alert('Tienes que completar todos los campos para publicar tu noticia!') </script>";
		//echo "<script>history.go(-1);</script>";
		return;
	}

	if ($type == 'n'){

		// guardar imagen de muestra
		$img_pathTo_save = "imagenes/portada_noticias/".$_FILES['portadaImg']['name'];

		$img_path="../../".$img_pathTo_save;

		if (!move_uploaded_file($_FILES['portadaImg']['tmp_name'],$img_path))
		{
			mysqli_close($conn);
			echo "<script>alert('Error al guardar imagen de portada') </script>";
			//echo "<script>history.go(-1);</script>";
			return;
		}

		// Ingresar la noticia en la base de datos

		$insert = mysqli_query ($conn,"INSERT INTO noticias (usuarioID, tituloNoticia, imagenPortada, 										contenidoNoticia, fechaCreo, descripcionNoticia, tipoEstadoID) 
									VALUES ('$usuario', '$titulo', '$img_pathTo_save', '$noticia', now(),'$descrip', 1)");
	}
	if ($type == 'e'){

			// guardar imagen de muestra
		$img_pathTo_save = "imagenes/portada_eventos/".$_FILES['imagen']['name'];

		$target=$_SERVER['DOCUMENT_ROOT']."/androidTest/imagenes/portada_eventos/";

		$img_path=$target.$_FILES['imagen']['name'];

		move_uploaded_file($_FILES['imagen']['tmp_name'],$img_path);

			$insert = mysqli_query($con,"INSERT INTO eventos (autor, titulo, imagen, evento,fecha,descripcion) 

			VALUES ('$_POST[autor]', '$titulo', '$img_pathTo_save', '$noticia','$fecha','$descrip')");

	}

	if(!$insert){
		echo mysqli_error($conn);
		mysqli_close($conn);
		echo "error al insertar noticia";
	//	echo "<script>history.go(-1);</script>";
		return;
	}


	mysqli_close($conn);
	echo "Publicación exitosa!";
//	echo "<script>history.go(-1);</script>";


// if ($edited == 't'){
// 	if (!empty($_POST['autor']) && !empty($_POST['titulo']) && !empty($_POST['novedad']) && !empty($_POST['descrip']) )
// 	{	
// 		$update = mysqli_query($con,"UPDATE noticias SET autor = '$_POST[autor]', titulo = '$titulo', descripcion = '$descrip', noticia = '$noticia' WHERE id_noticia = '$id' ");
// 	if(!$update)
// 		echo "error al insertar noticia";
// 	else
// 		echo "se ha publicado la noticia";	
// 	}else{
// 		echo "<script>alert('Tienes que completar todos los campos!') </script>";	
// 		mysqli_close($con);	
// 		echo "<script>history.go(-1);</script>";		
// 	}
	
// }
?>