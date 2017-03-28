<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta charset="utf-8">
	<link href="noticiasStyle.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
	<div id='notisContent'>
<?php
	include_once("connection.php");

	$con = mysqli_connect($_host,$_user,$_pass,$_db);
	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();


	$qryNoti = mysqli_query($con,"select * from eventos");

	while($qry = mysqli_fetch_array($qryNoti)){
		$titulo = utf8_encode($qry['titulo']);
echo"
		<article class='list_notis'>
		<aside>
		<a href='#'>
			<img src='http://localhost/androidTest/$qry[imagen]'  align='center' class='img_prev_noti' width='100px' height='100px'/>
			</a>
			</aside>			
			<div>
			<h2>
				<a href='#'>$titulo</a>
			</h2>
			<small id='autor' align='left'>Publicado por $qry[autor] </small><br/>
			<p>$qry[descripcion]...

			<small><a href='#' align='right'>Ver detalles</a></small></p>
			</div>
		</article><br/>";

	}

	mysqli_close($con);
?>
</div>
</body>
</html>