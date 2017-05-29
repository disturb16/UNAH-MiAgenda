<?php
	session_start();
	include_once("../../connection.php");

	$seccionId = mysqli_real_escape_string($conn, $_GET["seccionId"]);

	$qryPublicacion = mysqli_query($conn," SELECT p.publicacionAsignaturaID
												 ,p.tituloPublicacion		as titulo										
                                                 ,a.descripcion 			as tituloClase
											FROM publicaciones_asignatura p
											     inner join secciones s
														 on s.seccionID = p.seccionID
														and s.tipoEstadoID = 1
												 inner join asignaturas a
														 on a.asignaturaID = s.asignaturaID
														and a.tipoEstadoID = 1
													where p.seccionID = 1
											order by p.fechaCreo desc")
						or die(mysqli_error($conn));


?>
<input type="hidden" name="seccion" id="seccionId" value= <?php echo "'$seccionId'"; ?>  >


<ul id="contenedor-calificaciones " class="collapsible popout" data-collapsible="accordion">
<?php 
	
	foreach ($qryPublicacion as $publicacion){	

			$titulo = $publicacion["titulo"];
			$publicacionAsignaturaID = $publicacion["publicacionAsignaturaID"];
			$tituloClase = $publicacion["tituloClase"];

		?>
		<li>
	      <div class="collapsible-header"><i class="material-icons">list</i><?php echo $titulo; ?></div>
	      <div class="collapsible-body">
	      				
				<?php

					$qryComentario = mysqli_query($conn," SELECT
													        c.comentarioPublicacionID
													       ,c.comentario
													       ,c.fechaCreo
													       ,usr.usuarioID
													       ,usr.nombres
													       ,usr.profilePicture
													FROM comentarios_publicacion c
													     inner join usuarios usr 
																 on usr.usuarioID = c.usuarioID
																and usr.tipoEstadoID = 1
													where c.publicacionAsignaturaID = '$publicacionAsignaturaID'  ")
						or die(mysqli_error($conn));


					foreach($qryComentario as $comentario){

						$profilePic = $comentario["profilePicture"];
						$usrNombre = $comentario["nombres"];
						$comment = $comentario["comentario"];



						?>
						<div class="row">
							<div class="col s2">
								<img src=<?php echo "'../imagenes/perfil_pictures/$profilePic'"; ?> class="responsive-img" style="height: 80px; width: 100%">
							</div>
							<div class="col s8">
								<span class="grey-text">by </span><a href="#"><span><?php echo $usrNombre; ?></span></a><br>
								<span><?php echo $comment; ?></span>
							</div>
							
						</div>						
						<?php
					}
				?>
	      </div>
	    </li>
	
<?php	
}// end of parciales while

?>
</ul>

<!-- Formulario para agregar Asignatura -->
<div id="agregarPublicacion" class="modal modal-fixed-footer">
	<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat right"><li class="material-icons">close</li></a>
    <div class="modal-content">
    <div class="modal-header">
		<h4>Publicar noticia para <?php echo "$tituloClase"; ?> </h4>
	</div>
      
    	<form id="formAsignaturas" action="funcionesPHP/enviarPublicacionClase.php" method="post" class="col s12">
    		<input type="hidden" name="seccion" value=<?php echo "'$seccionId'"; ?> >
    		<input type="hidden" name="catedraticoID" value=<?php echo "'$_SESSION[usuarioID]'"; ?> >
    		<input type="hidden" name="tituloClase" value=<?php echo "'$tituloClase'"; ?> >

    		<div class="row">
		        <div class="input-field col s12">
		          <input id="titulo" name="titulo" type="text" class="validate">
		          <label for="titulo">Titulo</label>
		        </div>
		    </div>
		    <div class="input-field col s12">
	          <textarea id="content" name="content" class="materialize-textarea"></textarea>
	          <label for="content">Contenido</label>
	        </div>	      
	    </form>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancelar</a>
      <button type="submit" form="formAsignaturas" class="waves-effect waves-green btn-flat">Aceptar</button>
    </div>
  </div>

<!-- Boton agregar -->
<div class="fixed-action-btn">
	<a href="#agregarPublicacion" class="btn-floating btn-large waves-effect waves-light red right addSeccion"><i class="material-icons">add</i></a>
</div>



<script>	

	$(document).ready(function(){
	    $('.collapsible').collapsible();
	    $('.modal').modal();
	  });

</script>

<?php 
	mysqli_close($conn);
?>