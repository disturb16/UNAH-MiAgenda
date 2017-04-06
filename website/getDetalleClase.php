<?php

	$json = file_get_contents('php://input');
	$obj = json_decode($json); 

	$seccion = $obj->{'seccion'};

	include("connection.php");

	//query para obtener datos generales de la seccion
	$qry = mysqli_query($conn, "SELECT  asig.descripcion
										,sec.seccionID
								        ,sec.horaInicio
								        ,sec.horaFin
								        ,sec.salonClase
								        ,sec.edificio
								        ,usr.nombres
								        ,asig.codigoAsignatura
								   from secciones sec
								  		inner join asignaturas asig
								        		on sec.asignaturaID = asig.asignaturaID
										left join usuarios usr
								         	   on sec.usuarioID = usr.usuarioID                
								  where sec.seccionID = '$seccion' 
								  	AND sec.periodoAcademicoID = '1' ")  or die(mysqli_error($conn));




	if (!$qry){
		echo "Error";
		mysqli_close($conn);
		return;
	}

		$details = mysqli_fetch_array($qry);
		
		$titulo = utf8_encode($details['descripcion']);
		$seccion = utf8_encode($details['seccionID']);
		$aula = utf8_encode($details['salonClase']);
		$edificio = utf8_encode($details['edificio']);
		$horaInicio = utf8_encode($details['horaInicio']);
		$horaFinal = utf8_encode($details['horaFin']);
		$catedratico = utf8_encode($details['nombres']);
		$codigo = utf8_encode($details['codigoAsignatura']);
		
		$data = "{'classDetails':[{'titulo':'$titulo',
					'seccion':'$seccion',
					'aula':'$aula',
					'edificio':'$edificio',
					'horaInicio':'$horaInicio',
					'horaFinal':'$horaFinal',
					'catedratico':'$catedratico',
					'codigoMateria':'$codigo'
					}";
		$data .= "],";
				
				
				
	//obtener lista de publicaciones de la clase
	$qryComment = mysqli_query($conn,"select *
										from publicaciones_asignatura p 
									   where p.seccionID='$seccion'
									   ORDER BY p.publicacionAsignaturaID DESC");
	$data .= '"Posts":[
						{
						"postTitle":"dummy",
						"fecha":"none",
						"commentCount":"none"
					}';

	if(!$qryComment){
		echo "Error comment";
		mysqli_close($conn);
	}

	while($comment = mysqli_fetch_array($qryComment)){
		$titulo = $comment["tituloPublicacion"];
		$fecha = new DateTime($comment["fechaCreo"]);
		$date = $fecha->format("d/m/Y");
		$ID = $comment["publicacionAsignaturaID"];
		$qryCommentCount = mysqli_query($conn,"SELECT *
												  from comentarios_publicacion c 
												 where c.publicacionAsignaturaID ='$ID'");
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

	mysqli_close($conn);

?>