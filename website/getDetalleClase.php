<?php

	$json = file_get_contents('php://input');
	$obj = json_decode($json); 

	$seccion = $obj->{'seccion'};

	include("connection.php");

	//query para obtener datos generales de la seccion
	$qry = mysqli_query($conn, " select  m.materia_name, s.seccion, s.startHour, s.endHour,
								s.classroom, s.building, u.name, m.code
								from secciones s
								inner join materias m on s.materiaID = m.materiaID
								left join catedraticos c on s.catedraticoID = c.catedraticoID
								inner join usuarios u on c.userID = u.userID
								where s.seccion = '$seccion' AND (s.period = '2' and s.periodYear = '2016') ")  or die(mysqli_error($conn));




	if (!$qry){
		echo "Error";
	}

	else{
		$details = mysqli_fetch_array($qry);
		
		$titulo = utf8_encode($details['materia_name']);
		$seccion = utf8_encode($details['seccion']);
		$aula = utf8_encode($details['classroom']);
		$edificio = utf8_encode($details['building']);
		$horaInicio = utf8_encode($details['startHour']);
		$horaFinal = utf8_encode($details['endHour']);
		$catedratico = utf8_encode($details['name']);
		$codigo = utf8_encode($details['code']);
		
		$data = "{'classDetails':[{'titulo':'$titulo',
					'seccion':'$seccion',
					'aula':'$aula',
					'edificio':'$edificio',
					'horaInicio':'$horaInicio',
					'horaFinal':'$horaFinal',
					'catedratico':'$catedratico',
					'catedratico':'$catedratico',
					'codigoMateria':'$codigo'
					}";
		$data .= "],";
				}
				
				
	//obtener lista de publicaciones de la clase
	$qryComment = mysqli_query($conn,"select * from classPosts where seccion='$seccion' ORDER BY postID DESC");
	$data .= '"Posts":[
						{
						"postTitle":"dummy",
						"fecha":"none",
						"commentCount":"none"
					}';

	if(!$qryComment)
		echo "Error comment";
	else{
		while($comment = mysqli_fetch_array($qryComment)){
			$titulo = $comment["postTitle"];
			$fecha = new DateTime($comment["postDate"]);
			$date = $fecha->format("d/m/Y");
			$ID = $comment["postID"];
			$qryCommentCount = mysqli_query($conn,"select * from postComments where postID ='$ID'");
			$count = mysqli_num_rows($qryCommentCount);
			
			$data .= ",{
				'postTitle':'$titulo',
				'fecha':'$date',
				'postID':'$ID',
				'commentCount':'$count'
			}";
		}
	$data .= "]}";
		
		echo $data;
	}

	mysqli_close($conn);

?>