<?php
	session_start();
	include_once("connection.php");
	$con = mysqli_connect($_host,$_user,$_pass,$_db);

 	if (isset($_SESSION['s_priority']) == 1){

 	}
?>
<html>
<head>
  <meta charset="utf-8">
  <script src='javascript/jquery-1.11.2.min.js'></script>
  <script src="dist/jquery.magnific-popup.min.js"></script>
  <link rel="stylesheet" href="dist/magnific-popup.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);
    function drawChart() {


      var jsonData = $.ajax({
              url: "getScoresData.php",
              dataType: "json",
              async: false
              }).responseText;
 
        var jdata = jQuery.parseJSON(jsonData); 

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Fechas de Parcial');
      data.addColumn('number', 'Promedio de Calificaciones');

      var size = Object.keys(jdata.Scores).length;
                //define rows of data
        for (var i = 1; i < size; i++) {
          data.addRow([jdata.Scores[i].fecha + "(Parcial " + jdata.Scores[i].fechaParcial+")",parseInt(jdata.Scores[i].score)]);
        }

      var options = {
        chart: {
          title: 'Seguimiento de notas de parcial',
          subtitle: 'En base a 100%'
        },
        width: 1000,
        height: 500,
        axes: {
          x: {
            0: {side: 'bottom'}
          },
          y: {
                all: {
                    range: {
                        max: 110,
                        min: 0
                    }

                }
            }
        }
      };

      var chart = new google.charts.Line(document.getElementById('chart'));

      chart.draw(data, options);

      $(document).ready(function() {
        $('.btnEnable').magnificPopup({
          type: 'ajax',
          alignTop:false,
          closeOnContentClick: false
        });
      });
    }
  </script>
  <style>
    #content{
      width: 90%;
      margin: 20px auto;
      box-shadow: 0 0 1px #999;
      background-color: #fff;
    }
    #chart{
      width: 100%;
      padding: 10px;
    }
  </style>
  <link href="indexStyle.css" rel="stylesheet" media="all"/>
</head>
<body>
<div id="cabecera"> 
      <header>
        <nav>
          <h1>Unah Mi Agenda - Administración</h1>
          <a href='logOut.php' >Cerrar Sesión</a>
        </nav>
      </header>
    </div>
  <div id='content'>
	<div id='control-eval' style='padding: 10px;'>
  		<a class='btn btnEnable'  href='enableEvaluacion_PopUp.html' >Habilitar evaluación de alumnos</a>
      <a class='btn '  href='#' onclick='enableEvaluacion(0)'>Deshabilitar evaluación de alumnos</a>
	</div>
    <div id="chart"></div>
  </div>
</body>
<script src="functions.js"></script>
</html>
<?php
 	mysqli_close($con);
?>