<?php
include("connection.php");

$queryUser = mysqli_query($conn,"SELECT * FROM noticias ORDER BY noticiaID DESC LIMIT 0,5")
						or die(mysqli_error($conn));

$count = mysqli_num_rows($queryUser);

$data = '{"Noticias":[{"noticiaID":"none","titulo":"dummy","portada":"none"}';
$i = 0;

if (!$queryUser){
	echo "Error";}
else{
		while($notiData = mysqli_fetch_array($queryUser)){

			$id = $notiData['noticiaID'];
			$titulo = $notiData['tituloNoticia'];
			$img = "http://unahmiagenda.000webhostapp.com/".$notiData['imagenPortada'];
			$data .= ",{'noticiaID':'$id','titulo':'$titulo','portada':'$img'}";
		}
			$data .= "]}";
			
		echo $data;
	}
mysqli_close($conn);
?>