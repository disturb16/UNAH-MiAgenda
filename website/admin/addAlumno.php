<?php
	include("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);

	$seccion = mysqli_real_escape_string($con,$_GET["seccion"]);

	$qryUsers = mysqli_query($con, "select *
									from users u
									WHERE NOT EXISTS 
									(select userID from forma_003 f where f.seccion = '$seccion' and userID = u.userID) and (u.userType = 2) ");
	if (!$qryUsers) 
		echo "Error al obtener alumnos";
	else{
		echo"<div id='alumnosPopUp'> 
				<style>
					#alumnosPopUp{
						background-color:#fff;
						margin: 0 auto; 
						padding: 5px;
						width:90%;
					}
					a ul li{
						width: 40%;
						display: inline-block;
						vertical-align: top;
						text-decoration: none;
						list-style: none;
					}
					a{
						color: #000;
						text-decoration: none;
					}



				</style>";
		while ($data = mysqli_fetch_array($qryUsers)) {
			$cuenta = $data["cuenta"];
			$nombre = $data["name"];
			?>
					<a href='#' onclick='addToSeccion(<?php echo $cuenta; ?>, <?php echo $seccion; ?>)'>
		<?php echo"		<ul>
							<li>$cuenta</li>
							<li>$nombre</li>
						</ul>
					</a>
				";
		}
		echo"</div>";
	}

mysqli_close($con);
?>